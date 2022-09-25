<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\AdminInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $AdminInterface;

    public function __construct(AdminInterface $AdminInterface)
    {
        $this->AdminInterface = $AdminInterface;
    }

    public function allStaff()
    {
        return $this->AdminInterface->allStaff();
    }

    public function addStaff(Request $request)
    {
        return $this->AdminInterface->addStaff($request);
    }

    public function updateStaff(Request $request)
    {
        return $this->AdminInterface->updateStaff($request);
    }

    public function deleteStaff(Request $request)
    {
        return $this->AdminInterface->deleteStaff($request);
    }

    public function specificStaff(Request $request)
    {
        return $this->AdminInterface->specificStaff($request);
    }

    /** Start Clients Section */
    public function allClients(){
        return $this->AdminInterface->allClients();
    }

    public function addClient(Request $request){
        return $this->AdminInterface->addClient($request);
    }

    public function specificClient(Request $request)
    {
        return $this->AdminInterface->specificClient($request);
    }

    public function deleteClient(Request $request)
    {
        return $this->AdminInterface->deleteClient($request);
    }

    public function updateClient(Request $request){
        return $this->AdminInterface->updateClient($request);
    }



    /** Roles Section */
    public function staffRoles()
    {
        return $this->AdminInterface->staffRoles();
    }


    public function allLibraryItems()
    {
        return $this->AdminInterface->allLibraryItems();
    }

    public function addLibraryItem(Request $request)
    {
        return $this->AdminInterface->addLibraryItem($request);
    }

    public function deleteLibraryItem(Request $request)
    {
        return $this->AdminInterface->deleteLibraryItem($request);
    }

}
