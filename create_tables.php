<?php
include_once("queries_database.php");
createtables_ecommerce_orders();
createtables_refunds();
createtables_exchanges();
createtables_online_pl(); // Online_pl
createtables_gateway(); // Gateway
createtables_zones(); // Zones for logistics
createtables_shipping(); // Zones for shipping
createtables_extra_ship(); // Zones for shipping extra
createtables_edit_handling_costs(); // Zones to edit handling costs
createtables_marketing(); // For Marketing Cost
createtables_cac(); // For Marketing Cost
createtables_recurrency(); // For recurrency
createtables_product_sales(); // For product_sales
createtables_category_couple(); // For category_couple !
createtables_adset_header(); // For Facebook Adset
createtables_adset_data_yesterday(); // Facebook Adset Yesterday
createtables_adset_data_lifetime(); // Facebook Adset lifetime
createtables_adset_data_last_three_days(); // Facebook Adset 3 days (not include today)
createtables_adset_data_last_seven_days(); // Facebook Adset 7 days
createtables_adset_data_last_twenty_eight_days(); // Facebook Adset 28 days
createtables_daily_stock(); // Daily Stock
createtables_google_adgroup_header(); // Google



?>