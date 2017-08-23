<?php namespace App;

use Auth;
use DB;
use App\Shop;
use App\Branch;

class CheckBranch {

  public static function isBranch()
  {
    // $id = Auth::user()->id;
    // $is_branch = Branch::where('sub_id', '=', $id)->first();
    //
    // if(!is_null($is_branch)) {
    //   // is branch.
    //   return true;
    // } else {
    //   // not branch.
    //   return false;
    // }
    return Auth::user()->is_branch;
  }

  public static function mainShopId()
  {
    $id = Auth::user()->id;
    $branch = Branch::where('sub_id', '=', $id)->first();
    return $branch->main_id;
  }

}

?>
