# DataWarehouse Brava Fabrics

Everything is confidential and only serves for Brava Fabrics.

## Getting Started

You'll have to fulfill the access for : 
- Google Adwords API keychain_api.php
- Facebook API keychain_api.php 
- Database Bravafabrics database keychain.php 
- Datawarehouse database keychain.php

## main
The file main.php will be executed by crontab each day at 1 a.m. It will fulfill the database everyday with the CMS datas and send an email.

## main sales product
The file main_sales_product.php will be executed everyday at 1:10 a.m. It will fulfill all the cost.

## recurrency
The file recurrency_compute.php will be executed at the beginning of each month. It will returns the recurrency.