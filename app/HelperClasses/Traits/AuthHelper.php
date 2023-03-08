<?php

namespace App\HelperClasses\Traits;

use App\Models\Article;
use App\Models\Contact;
use App\Models\Document;
use App\Models\ElectedOfficials;
use App\Models\ElectedProfile;
use App\Models\Gallery;
use App\Models\ImportantPlaces;
use App\Models\Introduction;
use App\Models\ResourceMap;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Staff;
use App\Models\Ward;
use App\Models\WardOfficials;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

trait AuthHelper
{

    /**
     * Get Auth User
     *
     * @return Authenticatable|null
     */
    public function getAuthUser()
    {
        return auth()->user();
    }


    /**
     * Get Auth User
     *
     * @return int
     */
    public function getAuthUserType()
    {
        $user = $this->getAuthUser();

        return (int) ($user ? $user->type : 0);
    }


    /**
     * Get Auth User Id
     *
     * @return int
     */
    public function getAuthId(): int
    {
        $user = $this->getAuthUser();

        return (int) ($user ? $user->id : 0);
    }


    /**
     * Get Auth LG Id
     *
     * @return int
     */
    public function getAuthLgId(): int
    {
        $user = $this->getAuthUser();

        return (int) ($user ? $user->lg_id : 0);
    }


    /**
     * Get Auth Ministry Office Id
     *
     * @return int
     */
    public function getAuthMinistryOfficeId(): int
    {
        $user = $this->getAuthUser();

        return (int) ($user ? $user->office_id : 0);
    }


    /**
     * Get Auth Ministry Id
     *
     * @return int
     */
    public function getAuthMinistryId(): int
    {
        $user = $this->getAuthUser();

        return (int) ($user ? $user->ministry_id : 0);
    }


    /**
     * Get Auth Lg Officer
     *
     * @return bool
     */
    public function isAuthLgOfficer(): bool
    {
        $user = $this->getAuthUser();

        return isLgOfficer($user->roles[0]->slug);
    }

    /**
     * Get Auth Lg CAO
     *
     * @return bool
     */
    public function isAuthLgCao(): bool
    {
        $user = $this->getAuthUser();

        return isLgCao($user->roles[0]->slug);
    }

    /**
     * Get Auth Ministry Office CAO
     *
     * @return bool
     */
    public function isAuthMoCao(): bool
    {
        $user = $this->getAuthUser();

        return isMoCao($user->roles[0]->slug);
    }

    /**
     * Get Auth Ministry Office Officer
     *
     * @return bool
     */
    public function isAuthMoOfficer(): bool
    {
        $user = $this->getAuthUser();

        return isMoOfficer($user->roles[0]->slug);
    }

    /**
     * Get Auth Ministry Office CAO
     *
     * @return bool
     */
    public function isAuthMinistryCao(): bool
    {
        $user = $this->getAuthUser();

        return isMinistryCao($user->roles[0]->slug);
    }

    /**
     * Get Auth Ministry Office Officer
     *
     * @return bool
     */
    public function isAuthMinistryOfficer(): bool
    {
        $user = $this->getAuthUser();

        return isMinistryOfficer($user->roles[0]->slug);
    }

}
