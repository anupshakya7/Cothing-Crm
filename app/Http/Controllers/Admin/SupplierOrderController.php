<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SuppliersOrder;
use App\Models\SuppliersOrderItem;
use App\Models\SupplyCategoryItem;
use App\Models\SupplyItems;
use App\Models\Vendor;
use App\Models\VendorPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Krishnahimself\DateConverter\DateConverter;

class SupplierOrderController extends Controller
{
    public function index(Request $request)
    {

        $query = SuppliersOrder::with(['OrderItem','OrderItem.Category','OrderItem.Item','OrderItem.Category.parentCategory'])->orderBy('id', 'DESC');
        // Filter by product category
        if ($request->filled('vendor')) {
            $query->where('vendor_id',$request->input('vendor'));
        }
        
        // Filter by product name
        if ($request->filled('item')) {
            $query->where('supply_item', $request->input('item') );
        }

        $supplierOrders = $query->get()->groupBy('vendor_id');
        $suppliers = $supplierOrders->map(function($orders){
            return $orders->first();
        });

        $vendors = Vendor::where('status','Active')->get();
        $categories = SupplyCategoryItem::where('category_type',1)->where('status','Active')->get();
        $subcategories = SupplyCategoryItem::where('category_type',2)->where('status','Active')->get();
        $items = SupplyItems::where('status','Active')->get();
        return view('backend.supplyorder.index', compact('suppliers','vendors','categories','subcategories','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::where('status','Active')->get();
        $categories = SupplyCategoryItem::where('category_type',1)->where('status','Active')->get();
        $subcategories = SupplyCategoryItem::where('category_type',2)->where('status','Active')->get();
        $items = SupplyItems::where('status','Active')->get();
        $vendor_id = isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] :'';

        // Check if logged in user has "user.create" permission or not
        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }

        return view('backend.supplyorder.create', compact('vendors','items','categories','subcategories','vendor_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate our data
        $request->validate([
            'vendor' => 'required',
            'category' => 'required|array',
            'subcategory' => 'required|array',
            'item' => 'required|array',
            'price' => 'required|array',
            'quantity' => 'required|array',
            'total_amount' => 'required',
            'hasVAT'=>'required|integer|in:0,1',
            'date' => 'required',
        ]);

        // If validated, insert data
        $supplier = new SuppliersOrder();
        $supplier->vendor_id = $request->vendor;
        $supplier->remarks = $request->remarks;
        $supplier->total_price = $request->total_amount;
        $supplier->discount = $request->discount_amount;
        $supplier->hasVat = (int) $request->hasVAT;
        $supplier->date = $request->date;
        
        $supplier->confirmed_by = Auth::user()->id;
        // Assuming other fields exist like 'name' and 'status', you need to set them appropriately
        //Insert Data in Supply Order Table
        $supplier->save();
        if($request->item){
            foreach($request->item as $key => $supplyItem){
                $supplierItem = new SuppliersOrderItem();
                $supplierItem->supply_order_id = $supplier->id;
                $supplierItem->category_id = $request->category[$key];
                $supplierItem->subcategory_id = $request->subcategory[$key];
                $supplierItem->item_id = $supplyItem;
                $supplierItem->qty = $request->quantity[$key];
                $supplierItem->price = $request->price[$key];
                $supplierItem->save();
            }
        }

        // Flash success message to session
        session()->flash('success', 'Supply Order has been created!');

        // Redirect to index page
        return redirect()->route('admin.suppliers.index');
    }

    public function detail(Request $request){
        $month_date = $request->filled('month_date') ? $request->input('month_date') : '';
        $year_date = $request->filled('year_date') ? $request->input('year_date') : '';
        $last_year = '';

        $today_date = date('Y-m-d');
        $date = DateConverter::fromEnglishDate(date('Y',strtotime($today_date)), date('m',strtotime($today_date)),date('d',strtotime($today_date)))->toNepaliDate();
        $last_year = date('Y',strtotime($date));

        //From Date and To Date
        if($request->filled('fromDate') && $request->filled('toDate')){
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
        }else{
            $fromDate = '';
            $toDate = '';
        }
        
        //Data Type Monthly
        if($request->input('date_type') == 'Monthly'){   
            if($month_date){
                $year_month_date = $year_date.'-'.$month_date;
            }else{
                $year_date = $date;
                $year_date = date('Y',strtotime($year_date));
                $today_date = date('Y-m-d');
                $month_date = DateConverter::fromEnglishDate(date('Y',strtotime($today_date)),date('m',strtotime($today_date)),date('d',strtotime($today_date)))->toNepaliDate();
                $month_date = date('m',strtotime($month_date));
                $year_month_date = $year_date.'-'.$month_date;
            }
        }else{
            $year_month_date = null;
        }

        //Data Type Yearly
        if($request->input('date_type') == 'Yearly'){
            if(!$year_date){
                $year_date = $date;
                $year_date = date('Y',strtotime($year_date));
            }
        }
        

        $vendor = Vendor::with(['SupplyOrders'=>function($query) use($fromDate,$toDate,$year_month_date,$year_date){
            if(!empty($fromDate) && !empty($toDate)){
                $query->whereBetween('date',[$fromDate,$toDate]);
            }
            if(!empty($year_month_date)){
                $query->where('date','like',$year_month_date.'%');
            }
            if(!empty($year_date)){
                $query->where('date','like',$year_date.'%');
            }
            $query->orderBy('date');
        },'SupplyOrders.OrderItem','SupplyOrders.OrderItem.Category','SupplyOrders.OrderItem.Item','SupplyOrders.OrderItem.Category.parentCategory'])->where('id',$request->vendor)->first();
        
        return view('backend.supplyorder.detail',compact('vendor','last_year','month_date','year_date'));
    }


    public function edit($id)
    {
        $supplier = SuppliersOrder::find($id);
        $supplierItems = SuppliersOrderItem::where('supply_order_id',$id)->get();

        $vendors = Vendor::where('status','Active')->get();
        $categories = SupplyCategoryItem::where('category_type',1)->where('status','Active')->get();
        $subcategories = SupplyCategoryItem::where('category_type',2)->where('status','Active')->get();
        $items = SupplyItems::where('status','Active')->get();
        if (!is_null($supplier)) {
            return view('backend.supplyorder.edit', compact('supplier','supplierItems','vendors','categories','subcategories','items'));
        }

        session()->flash('error', 'Sorry ! No supply orders has been found !');
        return redirect()->route('admin.suppliers.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            //Old Validation
            // 'vendor' => 'required',
            // 'item' => 'required',
            // 'price' => 'required|numeric',
            // 'quantity' => 'required|numeric',
            // 'date' => 'required',

            //New Validation
            'vendor' => 'required',
            'category' => 'required|array',
            'subcategory' => 'required|array',
            'item' => 'required|array',
            'price' => 'required|array',
            'quantity' => 'required|array',
            'total_amount' => 'required',
            'hasVAT'=>'required|integer|in:0,1',
            'date' => 'required',
        ]);

        // Find the SuppliersOrder instance by its ID
        $supplier = SuppliersOrder::findOrFail($id);

        // Update the properties with the new values from the request
        $supplier->vendor_id = $request->vendor;
        $supplier->remarks = $request->remarks;
        $supplier->total_price = $request->total_amount;
        $supplier->discount = $request->discount_amount;
        $supplier->hasVat = (int) $request->hasVAT;
        $supplier->date = date('Y-m-d', strtotime($request->date));
        // Assuming other fields exist like 'confirmed_by', you need to set them appropriately

        // Save the updated instance
        $supplier->save();
        SuppliersOrderItem::where('supply_order_id',$id)->delete();
        if($request->item){
            foreach($request->item as $key => $supplyItem){
                $supplierItem = new SuppliersOrderItem();
                $supplierItem->supply_order_id = $id;
                $supplierItem->category_id = $request->category[$key];
                $supplierItem->subcategory_id = $request->subcategory[$key];
                $supplierItem->item_id = $supplyItem;
                $supplierItem->qty = $request->quantity[$key];
                $supplierItem->price = $request->price[$key];
                $supplierItem->save();
            }
        }

        // Flash success message to session
        session()->flash('success', 'Supply Order has been updated!');

        // Redirect to index page
        return redirect()->route('admin.suppliers.detail',['vendor'=>$request->vendor,'date_type'=>'Custom']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = SuppliersOrder::find($id);
        $vendor = $supplier->vendor_id;

        if (!is_null($supplier)) {
            // First Delete User Image & then Delete the user
            $supplier->delete();
            SuppliersOrderItem::where('supply_order_id',$id)->delete();
            $checkVendorPurchase = SuppliersOrder::where('vendor_id',$vendor)->get();
            if(count($checkVendorPurchase) == 0){
                VendorPayment::where('vendor_id',$vendor)->delete();
            }
            session()->flash('success', 'supplier order has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No vendor has been found !');
        }
        return redirect()->route('admin.suppliers.detail',['vendor'=>$supplier->vendor_id,'date_type'=>'Custom']);
    }

    public function destroyAll($vendor_id)
    {
        $suppliers = SuppliersOrder::where('vendor_id',$vendor_id)->get();

        if (!is_null($suppliers)) {
            // First Delete User Image & then Delete the user
            foreach($suppliers as $supplier){
                SuppliersOrderItem::where('supply_order_id',$supplier->id)->delete();   
                $supplier->delete();
            }
            VendorPayment::where('vendor_id',$vendor_id)->delete();
            session()->flash('success', 'supplier order has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No vendor has been found !');
        }
        return redirect()->route('admin.suppliers.index');
    }

    //Category Items Function
    public function categorySubCategory($category){
        $subcategories =  SupplyCategoryItem::where('category_type',2)->where('parent_category',$category)->where('status','Active')->get();
        return response()->json($subcategories);
    }

    public function categoryItems($category){
        $items = SupplyItems::where('supply_category_id',$category)->where('status','active')->get();
        return response()->json($items);
    }
}
