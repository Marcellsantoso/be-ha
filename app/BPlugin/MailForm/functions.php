<?php
//set menu format domain, menuname. menu url
Registor::registerAdminMenu("Order", "Order", "MailForm/OrderModel");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Order");
