<?php
include_once("queries_database.php");
createtables_online_pl(); // Online_pl
createtables_gateway(); // Gateway
createtables_zones(); // Zones for logistics
createtables_shipping(); // Zones for shipping
createtables_extra_ship(); // Zones for shipping extra
createtables_handling_costs(); // Zones for handling costs
createtables_edit_handling_costs(); // Zones to edit handling costs
createtables_marketing(); // For Marketing Cost

?>