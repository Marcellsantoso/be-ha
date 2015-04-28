<?php
/*ADMIN MENU */
Registor::emptyAdminMenu();
//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Account", "AccountLoginWeb/account");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Account");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role", "AccountLoginWeb/Role");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role2Role", "AccountLoginWeb/Role2Role");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role2Role");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role2RoleTree", "AccountLoginWeb/ShowRole2RoleLevel");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role2RoleTree");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role2Account", "AccountLoginWeb/Role2Account");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role2Account");

//set menu format domain, menuname. menu url
Registor::registerAdminMenu("UserAndRoles", "Role2Menu", "RoleWeb/Role2Menu");
//set yang bisa lihat menu
Registor::setDomainAndRoleMenu("Role2Menu");


