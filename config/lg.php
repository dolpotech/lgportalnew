<?php

return [
    'info_collection_type'  => ['circular', 'invitational', 'information_collection'],
    'template_fields_type'  => ['number', 'text', 'textarea', 'select', 'checkbox', 'date', 'file', 'radio', 'email', 'phone'],
    'field_option_type'     => ['select', 'checkbox', 'radio'],
    'info_collection_status' => ['pending', 'processing', 'completed'],
    'roles'                 => [
        'admin',
        'ministry_admin', 'ministry_officer', 'ministry_cao',
        'lg_admin', 'lg_cao', 'lg_officer',
        'mo_admin', 'mo_cao', 'mo_officers'
    ],
    'ministry_roles'        => ['ministry_admin', 'ministry_officer', 'ministry_cao'],
    'lg_roles'              => ['lg_admin', 'lg_cao', 'lg_officer'],
    'ministry_office_roles' => ['mo_admin', 'mo_cao', 'mo_officers'],
    'user_types'            => ['ministry', 'local_government', 'ministry_office'],
    'document_status'       => ['pending', 'processing', 'approve', 'completed'],
    'admin_roles'           => ['admin'],
    'template_insertion_type' => ['single', 'multiple'],
    'super_admin'           => 'super_admin',
    'lg_admin_role'         => 'lg_admin',
    'lg_cao_role'           => 'lg_cao',
    'lg_officer_role'       => 'lg_officer',
    'ministry_admin_role'   => 'ministry_admin',
    'ministry_cao_role'     => 'ministry_cao',
    'ministry_officer_role' => 'ministry_officer',
    'ministry_user_role'    => 'ministry_user',
    'mo_admin_role'         => 'mo_admin',
    'mo_cao_role'           => 'mo_cao',
    'mo_officer_role'       => 'mo_officers',
    'priority_level'        => ['medium', 'high'],
];
