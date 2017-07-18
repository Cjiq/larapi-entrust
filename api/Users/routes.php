<?php
// Users
$router->get('/users', 'UserController@getAll');
$router->get('/users/{id}', 'UserController@getById');
$router->post('/users', 'UserController@create');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@delete');

$router->get('/users/email/{email}', 'UserController@getByEmail');

$router->put('/users/{id}/roles/{role_id}', 'UserController@addRole');
$router->delete('/users/{id}/roles/{role_id}', 'UserController@deleteRole');

// Roles
$router->get('/roles', 'RoleController@getAll');
$router->get('/roles/{id}', 'RoleController@getById');
$router->post('/roles', 'RoleController@create');
$router->put('/roles/{id}', 'RoleController@update');
$router->delete('/roles/{id}', 'RoleController@delete');

$router->put('/roles/{id}/permissions/{permission_id}', 'RoleController@addPermission');
$router->delete('/roles/{id}/permissions/{permission_id}', 'RoleController@deletePermission');

// Permissions
$router->get('/permissions', 'PermissionController@getAll');
$router->get('/permissions/{id}', 'PermissionController@getById');
$router->post('/permissions', 'PermissionController@create');
$router->put('/permissions/{id}', 'PermissionController@update');
$router->delete('/permissions/{id}', 'PermissionController@delete');