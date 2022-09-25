<?php

namespace App\Http\Interfaces;

/** Created By Mohamed Gouda */

interface AdminInterface{

    /** Staff Section */
    public function allStaff();

    public function addStaff($request);

    public function deleteStaff($request);

    public function updateStaff($request);

    public function specificStaff($request);

    /** Clients Section */
    public function allClients();

    public function specificClient($request);

    public function addClient($request);

    public function deleteClient($request);

    public function updateClient($request);

    /** Roles Section */
    public function staffRoles();

    /** Start Library */
    public function allLibraryItems();

    public function addLibraryItem($request);

    public function deleteLibraryItem($request);


}
