<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Block\Adminhtml\Activity;

class View extends \Magento\Backend\Block\Template
{
    public function getResponse(): string
    {
        return <<<'EOT'
{
	"message": "-",
	"warning": "-",
	"request_id": "98eae35efff24dd0974c21a847127184",
	"response": {
		"description": "description",
		"weight": 1,
		"pre_order": {
			"days_to_ship": 1,
			"is_pre_order": true
		},
		"item_name": "Hello Product",
		"images": {
			"image_id_list": [
				"-"
			],
			"image_url_list": [
				"-"
			]
		},
		"item_status": "NORMAL",
		"price_info": {
			"current_price": 148.02,
			"original_price": 148.02
		},
		"logistic_info": [
			{
				"size_id": 0,
				"shipping_fee": 0.1,
				"enabled": true,
				"logistic_id": 88014,
				"is_free": true
			}
		],
		"item_id": 3000142341,
		"attributes": [
			{
				"attribute_id": 4990,
				"attribute_value_list": [
					{
						"original_value_name": "Samsung ID",
						"value_id": 32142,
						"value_unit": "kg"
					}
				]
			}
		],
		"category_id": 14695,
		"dimension": {
			"package_width": 11,
			"package_length": 11,
			"package_height": 11
		},
		"condition": "NEW",
		"video_info": [
			{
				"video_url": "https://cvf.shopee.sg/file/c67b847c954fd710e0d35ef1e22378d1",
				"thumbnail_url": "https://cf.shopee.sg/file/6fc53c203151635da72151cfbad03cdf",
				"duration": 15
			}
		],
		"wholesale": [
			{
				"min_count": 1,
				"max_count": 100,
				"unit_price": 13.3
			}
		],
		"brand": {
			"brand_id": 0,
			"original_brand_name": "nike"
		},
		"item_dangerous": 0,
		"description_info": {
			"extended_description": {
				"field_list": [
					{
						"field_type": "-",
						"text": "-",
						"image_info": {
							"image_id": "-"
						}
					}
				]
			}
		},
		"description_type": "-",
		"complaint_policy": {
			"warranty_time": "ONE_YEAR",
			"exclude_entrepreneur_warranty": true,
			"complaint_address_id": 0,
			"additional_information": "-"
		},
		"seller_stock": [
			{
				"location_id": "-",
				"stock": 0
			}
		]
	},
	"error": "-"
}
EOT;
    }

    public function isValidJson(string $json): bool
    {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function getTrace(): void
    {
        $debugBackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $lines = [];

        foreach ($debugBackTrace as $item) {
            $line = @$item['class'] . @$item['type'] . @$item['function'];
            $lines[] = $line;
        }

        if ($lines === []) {
            $lines[] = __('No trace available');
        }

        echo '<div class="stack-trace">';
        echo '<pre><code class="stack-trace-content">';
        foreach ($lines as $line) {
            echo sprintf("<div class='line'>%s</div>", $line);
        }

        echo '</code></pre>';
        echo '</div>';
    }
}
