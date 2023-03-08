<?php
function success(string $message, $data = null, int $code = 200)
{
    $responseData = [
        'success' => true,
        'message' => $message,
    ];
    if (null != $data) {
        $responseData['data'] = $data;
    }
    return response()->json($responseData, $code);
}

function error(string $message, int $code, $data = null)
{
    $responseData = [
        'success' => false,
        'message' => $message,
    ];
    if (null != $data) {
        $responseData['data'] = $data;
    }
    return response()->json($responseData, $code);
}

if (!function_exists('selectAllInformationKeys')) {
    function selectAllInformationKeys() {
        return [
            selectAllLgByDistrictKey(),
            selectAllLgByProvinceKey(),
            selectAllMinistryByProvince(),
            selectAllMinistryOfficeByProvince(),
            selectAllMinistryOfficeByMinistry(),
        ];
    }
}

if (!function_exists('selectAllLgByDistrictKey')) {
    function selectAllLgByDistrictKey() {
        return 'lg_by_district';
    }
}
if (!function_exists('selectAllLgByProvinceKey')) {
    function selectAllLgByProvinceKey() {
        return 'lg_by_province';
    }
}
if (!function_exists('selectAllMinistryByProvince')) {
    function selectAllMinistryByProvince() {
        return 'ministry_by_province';
    }
}
if (!function_exists('selectAllMinistryOfficeByProvince')) {
    function selectAllMinistryOfficeByProvince() {
        return 'ministry_office_by_province';
    }
}
if (!function_exists('selectAllMinistryOfficeByMinistry')) {
    function selectAllMinistryOfficeByMinistry() {
        return 'ministry_office_by_ministry';
    }
}

if (!function_exists('isValidDate')) {
    function isValidDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}



if (!function_exists('getFieldTypes')) {
    function getFieldTypes(): array
    {
        return config('lg.template_fields_type');
    }
}

if (!function_exists('getTemplateFieldsForVueJs')) {
    function getTemplateFieldsForVueJs(): array
    {
        return array_map(function ($type) {
            return [
                'label' => ucfirst($type),
                'value' => $type,
            ];
        }, getFieldTypes());
    }
}

if (!function_exists('getFieldOptionTypes')) {
    function getFieldOptionTypes(): array
    {
        return config('lg.field_option_type');
    }
}

if (!function_exists('getTemplateInsertionType')) {
    function getTemplateInsertionType(): array
    {
        return config('lg.template_insertion_type');
    }
}

if (!function_exists('getInfoCollectionType')) {
    function getInfoCollectionType(): array
    {
        return config('lg.info_collection_type');
    }
}
if (!function_exists('getInformationStatus')) {
    function getInformationStatus(): array
    {
        return config('lg.info_collection_status');
    }
}
if (!function_exists('getCircularInfoType')) {
    function getCircularInfoType(): string
    {
        return 'circular';
    }
}
if (!function_exists('getInvitationalInfoType')) {
    function getInvitationalInfoType(): string
    {
        return 'invitational';
    }
}
if (!function_exists('getInformationCollectionInfoType')) {
    function getInformationCollectionInfoType(): string
    {
        return 'information_collection';
    }
}

if (!function_exists('getPriorityLevel')) {
    function getPriorityLevel(): array
    {
        return config('lg.priority_level');
    }
}
if (!function_exists('getDocumentStatus')) {
    function getDocumentStatus(): array
    {
        return config('lg.document_status');
    }
}


if (!function_exists('getUserRoles')) {
    function getUserRoles(): array
    {
        return config('lg.roles');
    }
}

if (!function_exists('getMinistryRoles')) {
    function getMinistryRoles(): array
    {
        return config('lg.ministry_roles');
    }
}

if (!function_exists('getMinistryOfficeRoles')) {
    function getMinistryOfficeRoles(): array
    {
        return config('lg.ministry_office_roles');
    }
}

if (!function_exists('getAdminRoles')) {
    function getAdminRoles(): array
    {
        return config('lg.admin_roles');
    }
}

if (!function_exists('getLgRoles')) {
    function getLgRoles(): array
    {
        return config('lg.lg_roles');
    }
}

if (!function_exists('getMinistryAdminRole')) {
    function getMinistryAdminRole(): string
    {
        return config('lg.ministry_admin_role');
    }
}

if (!function_exists('getMinistryOfficeAdminRole')) {
    function getMinistryOfficeAdminRole(): string
    {
        return config('lg.mo_admin_role');
    }
}

if (!function_exists('getMinistryOfficeCaoRole')) {
    function getMinistryOfficeCaoRole(): string
    {
        return config('lg.mo_cao_role');
    }
}

if (!function_exists('getMinistryOfficeOfficerRole')) {
    function getMinistryOfficeOfficerRole(): string
    {
        return config('lg.mo_officer_role');
    }
}

if (!function_exists('getSuperAdminRole')) {
    function getSuperAdminRole(): string
    {
        return config('lg.super_admin');
    }
}

if (!function_exists('getMinistryOfficerRole')) {
    function getMinistryOfficerRole(): string
    {
        return config('lg.ministry_officer_role');
    }
}

if (!function_exists('getMinistryUserRole')) {
    function getMinistryUserRole(): string
    {
        return config('lg.ministry_user_role');
    }
}

if (!function_exists('getMinistryAdminRole')) {
    function getMinistryAdminRole(): string
    {
        return config('lg.ministry_admin_role');
    }
}

if (!function_exists('getMinistryCaoRole')) {
    function getMinistryCaoRole(): string
    {
        return config('lg.ministry_cao_role');
    }
}

if (!function_exists('getMinistryOfficerRole')) {
    function getLgOfficerRole(): string
    {
        return config('lg.ministry_officer_role');
    }
}


if (!function_exists('getLgAdminRole')) {
    function getLgAdminRole(): string
    {
        return config('lg.lg_admin_role');
    }
}

if (!function_exists('getLgCaoRole')) {
    function getLgCaoRole(): string
    {
        return config('lg.lg_cao_role');
    }
}

if (!function_exists('getLgOfficerRole')) {
    function getLgOfficerRole(): string
    {
        return config('lg.lg_officer_role');
    }
}

if (!function_exists('getUserType')) {
    function getUserType(): array
    {
        return config('lg.user_types');
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin($slug): bool
    {
        return $slug == getSuperAdminRole();
    }
}

if (!function_exists('isLgOfficer')) {
    function isLgOfficer($slug): bool
    {
        return $slug == getLgOfficerRole();
    }
}

if (!function_exists('isLgAdmin')) {
    function isLgAdmin($slug): bool
    {
        return $slug == getLgAdminRole();
    }
}

if (!function_exists('isLgCao')) {
    function isLgCao($slug): bool
    {
        return $slug == getLgCaoRole();
    }
}

if (!function_exists('isMoCao')) {
    function isMoCao($slug): bool
    {
        return $slug == getMinistryOfficeCaoRole();
    }
}

if (!function_exists('isMoOfficer')) {
    function isMoOfficer($slug): bool
    {
        return $slug == getMinistryOfficeOfficerRole();
    }
}

if (!function_exists('isMinistryCao')) {
    function isMinistryCao($slug): bool
    {
        return $slug == getMinistryCaoRole();
    }
}

if (!function_exists('isMinistryOfficer')) {
    function isMinistryOfficer($slug): bool
    {
        return $slug == getMinistryOfficerRole();
    }
}


if (!function_exists('getPendingStatus')) {
    function getPendingStatus(): string
    {
        return 'pending';
    }
}

if (!function_exists('getProcessingStatus')) {
    function getProcessingStatus(): string
    {
        return 'processing';
    }
}

if (!function_exists('getApprovalStatus')) {
    function getApprovalStatus(): string
    {
        return 'approve';
    }
}

if (!function_exists('getRejectedStatus')) {
    function getRejectedStatus(): string
    {
        return 'rejected';
    }
}

if (!function_exists('getCompletedStatus')) {
    function getCompletedStatus(): string
    {
        return 'completed';
    }
}


if (!function_exists('getCurrentDateTime')) {
    function getCurrentDateTime(): string
    {
        return date('Y-m-d H:i:s');
    }
}



if (!function_exists('isStringEmpty')) {
    function isStringEmpty(string $string): bool
    {
        return $string === '' || is_null($string);
    }
}


if (!function_exists('getInformationStoragePath')) {
    function getInformationStoragePath(string $path = ''): string
    {
        return storage_path('app'.DIRECTORY_SEPARATOR.'information'.(!empty($path) ? DIRECTORY_SEPARATOR.$path : ''));
    }
}

if (!function_exists('getStorageAppPath')) {
    function getStorageAppPath(string $path = ''): string
    {
        return storage_path('app'.(!empty($path) ? DIRECTORY_SEPARATOR.$path : ''));
    }
}

if (!function_exists('getInformationStorageRelativePath')) {
    function getInformationStorageRelativePath(string $path = ''): string
    {
        return (!empty($path) ? DIRECTORY_SEPARATOR.$path : '');
    }
}

if (!function_exists('getDocumentStoragePath')) {
    function getDocumentStoragePath(string $path = ''): string
    {
        return storage_path('app'.DIRECTORY_SEPARATOR.'information'.(!empty($path) ? DIRECTORY_SEPARATOR.$path : ''));
    }
}

if (!function_exists('getDocumentStorageRelativePath')) {
    function getDocumentStorageRelativePath(string $path = ''): string
    {
        return (!empty($path) ? DIRECTORY_SEPARATOR.$path : '');
    }
}

if (!function_exists('convertToArray')) {
    function convertToArray($data): array
    {
        if (is_string($data)) {
            return (array) json_decode($data, 1);
        }

        if (is_array($data)) {
            return $data;
        }

        return (array) $data;
    }
}

if (!function_exists('isInformationInvitational')) {
    function isInformationInvitational($informationType): bool
    {
        return $informationType === 'invitational';
    }
}

if (!function_exists('getInformationStorageUrl')) {
    function getInformationStorageUrl($path = ''): string
    {
        return url('public/app_storage').(!empty($path) ? DIRECTORY_SEPARATOR.$path : '');
    }
}

if (!function_exists('getDocumentStorageUrl')) {
    function getDocumentStorageUrl($path = ''): string
    {
        return url('public/app_storage').(!empty($path) ? DIRECTORY_SEPARATOR.$path : '');
    }
}

if (! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset("public/".$path, $secure);
    }
}

if (!function_exists('getMinistryUserType')) {
    function getMinistryUserType(): string
    {
        return 'ministry';
    }
}

if (!function_exists('getLgUserType')) {
    function getLgUserType(): string
    {
        return 'local_government';
    }
}

if (!function_exists('getMinistryOfficeUserType')) {
    function getMinistryOfficeUserType(): string
    {
        return 'ministry_office';
    }
}

if (!function_exists('getLgByDistrict')) {
    function getLgByDistrict(): string
    {
        return 'lg_by_district';
    }
}

if (!function_exists('getLgByProvince')) {
    function getLgByProvince(): string
    {
        return 'lg_by_province';
    }
}

if (!function_exists('getAllMinistry')) {
    function getAllMinistry(): string
    {
        return 'all_ministries';
    }
}

if (!function_exists('getAllMinistryOfficeByMinistryId')) {
    function getAllMinistryOfficeByMinistryId(): string
    {
        return 'all_by_ministry_offices';
    }
}






