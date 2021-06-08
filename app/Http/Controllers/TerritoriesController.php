<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class TerritoriesController extends Controller
{
    public function all() {
        $apiResponse = Http::get("https://netzwelt-devtest.azurewebsites.net/Territories/All");
        $data = json_decode($apiResponse)->data;
        $territories = $this->groupItems($data, "territories");

        $response = [
          "status" => "OK",
          "message" => "",
          "territories" => $territories
        ];

        return response(json_encode($response), 200)->header('Content-Type', 'application/json');
    }

    protected function groupItems($items, $subItemsKey = "items") {
      $groupedItems = [];
      $itemRef = [];
      for($i = 0; $i < count($items); $i++) {
        $item = $items[$i];

        $itemRef[$item->id] = $item;
        if($item->parent == null) {
          $groupedItems[] = $item;
        }
        else {
          $parentItem = $itemRef[$item->parent];
          if(!property_exists($parentItem, $subItemsKey)) {
            $parentItem->{$subItemsKey} = [];
          }
          $parentItem->{$subItemsKey}[] = $item;
        }
      }
      $itemRef = null;
      return $groupedItems;
    }
}
