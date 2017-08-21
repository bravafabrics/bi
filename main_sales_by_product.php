<?php

include("queries_database.php"); // About our special database
include("prestashop.php"); // About the prestashop methods 
include("functions.php");

date_default_timezone_set("Europe/Madrid");		
$set_local_time = new DateTimeZone("Europe/Madrid"); // Lets Set the timezone (Europe)
$yesterday_date = new DateTime(date("Y-m-d"), $set_local_time); // Today's date !
$yesterday_date->modify('-1 day');
$date_yesterday = $yesterday_date->format("Y-m-d");



$start  = new DateTime('-881 days', new DateTimeZone('UTC'));
$period = new DatePeriod($start, new DateInterval('P1D'), 881);

 // foreach($period as $date) { 

	// $date_yesterday = $date->format("Y-m-d");
$results_sales = report_for_product_sales($date_yesterday);
$datas = $results_sales->fetchAll();
foreach($datas as $data) {  
fulfill_product_sales($data['id_category'], $data['date'], $data['countrycode'], 
$data['id_product'], $data['short_name_1'], $data['short_name_2'], $data['unit_sold'], $data['fp/dis'], $data['gentle'], $data['category_name'], $data['size'],
$data['sales'], $data['cogs']);

 }

$results_sales->closeCursor();
 // }


// foreach($period as $date) {
	// $date_yesterday = $date->format("Y-m-d");
$result = get_infos_for_the_cross_by_date($date_yesterday);
$datas_for_cross = $result->fetchAll();
foreach($datas_for_cross as $data_for_cross) { 

 $data = get_the_cross_from_ps_by_id_order($data_for_cross['id_order']);
 $array_couple_id = array_values(getTheCouple($data));
 $array_couple_name = array_values(getTheCoupleName($array_couple_id));
 for ($i = 0; $i < sizeOf($array_couple_id); $i++) {  
 fulfill_category_couple($data_for_cross['date'], $data_for_cross['countrycode'], $data_for_cross['id_order'], $array_couple_id[$i], $array_couple_name[$i]);

 }


}
$result->closeCursor();
// }

// ALL ABOUT THE DAILY STOCKS ******************** //
$con=mysqli_connect(DBPS_HOST, DBPS_USER, DBPS_PASS, DBPS_DATABASE);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql = '
CREATE TABLE IF NOT EXISTS temp_orders(
id_order INT(10),
date DATE,
PRIMARY KEY (id_order)
);
CREATE TABLE IF NOT EXISTS temp_product_minimum_orders(
date DATE,
id_product INT(10),
PRIMARY KEY (id_product)
);

CREATE TABLE IF NOT EXISTS temp_interval(
id_product INT(10),
inter INT(10),
date DATE,
PRIMARY KEY (id_product)
);

CREATE TABLE IF NOT EXISTS temp_quantity(
id_product INT(10),
quantity INT(10),
PRIMARY KEY (id_product)
);
CREATE TABLE IF NOT EXISTS temp_size(
id_product INT(10),
count_size INT (10),
quantity_size INT (10),
PRIMARY KEY (id_product)
);



INSERT INTO temp_size (id_product, count_size, quantity_size)
SELECT id_product, sum(CASE WHEN id_product_attribute = 0 THEN 0 ELSE 1 END)  AS "count_size",
sum(CASE WHEN quantity = 0 THEN 0 ELSE 1 END) AS "quantity_size" FROM ps_stock_available WHERE id_product_attribute != "0" GROUP BY id_product;

INSERT INTO temp_orders (id_order, date)
SELECT o.id_order, DATE_FORMAT(o.date_add,"%Y-%m-%d") FROM ps_orders o 
WHERE o.date_add BETWEEN (NOW()-INTERVAL 1 DAY) - INTERVAL 13 DAY AND (NOW()-INTERVAL 1 DAY)
;

INSERT INTO temp_product_minimum_orders (date, id_product)
SELECT min(tor.date), od.product_id FROM ps_order_detail od
inner join temp_orders tor on tor.id_order = od.id_order 
GROUP BY od.product_id
;

INSERT INTO temp_interval (id_product, inter, date)
SELECT p.id_product, 
IFNULL(DATEDIFF((NOW()-INTERVAL 1 DAY), tpmo.date)+1, 0),
IFNULL(tpmo.date, "1990-01-01") 
 FROM ps_product p
left join temp_product_minimum_orders tpmo on tpmo.id_product = p.id_product;

INSERT INTO temp_quantity (id_product, quantity)
SELECT od.product_id AS "product_id", sum(od.product_quantity) AS "quantity"  FROM ps_order_detail od 
inner join ps_orders o on o.id_order = od.id_order
WHERE DATE_FORMAT(o.date_add,"%Y-%m-%d") between (SELECT tir.date FROM temp_interval tir WHERE tir.id_product = od.product_id ) and (NOW()-INTERVAL 1 DAY)
GROUP BY od.product_id
; 

SELECT psc.id_category AS "id_category", "'.$date_yesterday.'" AS "date", psl.name as "name_cateogry",  
od.product_id AS "id_product", REPLACE(ppl.name, "\'", " ") as "short_name_1", p.reference as "short_name_2",
 GREATEST(sa.quantity,0) AS "current_stock", TRUNCATE(GREATEST(sa.quantity,0)*p.wholesale_price,2) As "euro_stock",
tsz.quantity_size/tsz.count_size AS "percentage_size",
IFNULL(tq.quantity/tir.inter, 0) AS "units_sold", IFNULL(tq.quantity/tir.inter, 0)/sa.quantity AS "days_stock"
 FROM ps_product p 
left join ps_order_detail od on p.id_product = od.product_id
inner join ps_orders o on od.id_order = o.id_order
inner join ps_category psc on psc.id_category = p.id_category_default
inner join ps_category_lang psl 
 on psl.id_category = p.id_category_default and psl.id_lang="1"
inner join ps_product_lang ppl on ppl.id_product = p.id_product AND ppl.id_lang = "1"
inner join ps_stock_available sa on sa.id_product = p.id_product AND sa.id_product_attribute=0
inner join temp_size tsz on tsz.id_product = p.id_product

left join temp_quantity tq on tq.id_product = p.id_product
left join temp_interval tir on tir.id_product = p.id_product
WHERE sa.quantity > 0 GROUP BY od.product_id  ORDER BY p.id_product ASC;

DROP TABLE temp_orders;
DROP TABLE temp_product_minimum_orders;
DROP TABLE temp_interval;
DROP TABLE temp_quantity;
DROP TABLE temp_size

';
if (mysqli_multi_query($con,$sql))
{
  do
    {
    // Store first result set
    if ($result=mysqli_store_result($con)) {
      // Fetch one and one row
	while ($row=mysqli_fetch_row($result)) fulfill_daily_stocks($row[0], $row[1], $row[2], $row[3], $row[4],
$row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
      // Free result set
      mysqli_free_result($result);
      }
    }
  while (mysqli_next_result($con));
}

mysqli_close($con);


// END 
?>