<?php

declare(strict_types=1);

namespace Sample\CatalogImportExport\Model\Import;

use Magento\CatalogImportExport\Model\Export\Product as ProductExportModel;
use Magento\CatalogImportExport\Model\Import\Product as ProductImportModel;

class Product extends ProductImportModel
{
    public const BRAND_FIELD = 'brand';
    public const CATEGORY_SERIES_FIELD = 'category_series';
    public const NAME_FIELD = 'name';

    protected function getUrlKey($rowData)
    {
        if (isset($rowData[self::URL_KEY])) {
            return parent::getUrlKey($rowData);
        }

        $additionalAttributes = $this->getAdditionalAttributes(
            $rowData[ProductExportModel::COL_ADDITIONAL_ATTRIBUTES] ?? []
        );
        if (
            !empty($additionalAttributes[self::BRAND_FIELD])
            && !empty($additionalAttributes[self::CATEGORY_SERIES_FIELD])
            && !empty($rowData[self::NAME_FIELD])
        ) {
            $urlString = implode('-', [
                $additionalAttributes[self::BRAND_FIELD],
                $additionalAttributes[self::CATEGORY_SERIES_FIELD],
                $rowData[self::NAME_FIELD]
            ]);
            return $this->productUrl->formatUrlKey($urlString);
        }

        return parent::getUrlKey($rowData);
    }

    private function getAdditionalAttributes(string $additionalAttributesFieldValue): array
    {
        $additionalAttributes = explode(',', $additionalAttributesFieldValue);

        $attributesData = [];
        foreach($additionalAttributes as $attributeString) {
            [$attributeCode, $attributeValue] = explode('=', $attributeString);
            if (!empty($attributeCode) && !empty($attributeValue)) {
                $attributesData[$attributeCode] = $attributeValue;
            }
        }

        return $attributesData;
    }
}
