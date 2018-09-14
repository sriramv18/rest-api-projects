import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { MastersService } from '../../../service/master/masters.service';
import { ProductDialogComponent } from '../product-dialog/product-dialog.component';
import { ProductMaster } from '../../../model/product-master';
//import { DataSource } from '@angular/cdk/table';
import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent  {
  
  isPopupOpened = true;
  
  TempArray : any = [];
  Temp : any = [];
  TTarray : any = [];
  Temp2 : any = [];
  
  private  contacts:  any = [];

  //displayedColumns = ['product_id','name','abbr','createdon','updatedon'];
  displayedColumns = ['product_id','name','abbr','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];
  // -- @ViewChild(MatPaginator) paginator: MatPaginator;
  // -- @ViewChild(MatSort) sort: MatSort;
   dataSource = new UserDataSource(this._ProductService);

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
  //dataSource: DataTableDataSource;
  //dataSource = new MatTableDataSource<ProductMaster>;
  //dataSource: MatTableDataSource<ProductMaster>;
  
  
  constructor(private dialog: MatDialog, private _ProductService: MastersService) {

    // let newarray = this._ps.getProd().subscribe((dataresult: any[]) => { // good!
    //   for (let item of dataresult) {
    //     this.data.push(item);
    //   }
    //   return this.data;
    // });

    // this.Temp2 = this._ProductService.getProd();

    // console.log("mattable", this.Temp2);

    
    // Assign the data to the data source for the table to render
  //  this.dataSource = new MatTableDataSource(this.Temp2);
  
    
  }

   get ProductMasterList() {
     return this._ProductService.getAllProduct();
   }

  
  // getTempArray() {
  //   this._ProductService.getProductMasterArrayData()
  //       .subscribe(_ProductArr => this.TempArray = _ProductArr);
  // }

  public getProdContactsByService(){
    this._ProductService.getAllProduct().subscribe((data:any) => {
      this.contacts = data;
     // console.log(data);
      let rec = Object.keys(this.contacts)[2];
     // console.log(this.contacts[rec]);
      this.Temp = this.contacts[rec];
      console.log(this.Temp);
      // for ( let key  in this.contacts) {
      //   console.log('------------'+ key);
      //  console.log(this.contacts(key));
      // }
    });
 }


//  public getpostContacts(){
//   this._ProductService.addProd({name: 'Non Residential Premises Loans',abbr: 'NRPL'})
//   .subscribe(hero => this.TempArray.push(hero));
//  }

    // getProd(): void {
    //   this._ProductService.get2Prod()
    //       .subscribe(heroes => this.Temp = heroes);
    // }
  
  //displayedColumns: string[] = ['ID','ClassifiedName'];
  //dataSource = this.ProductMasterList;
  
  
  //displayedColumns = ['name', 'email', 'phone', 'company'];
  //displayedColumns = ['name', 'email', 'phone', 'company'];
  // displayedColumns = ['product_id','name','abbr','createdon','fk_createdby','updatedon', 'isactive', 'fk_updatedby','actions'];
  // // -- @ViewChild(MatPaginator) paginator: MatPaginator;
  // // -- @ViewChild(MatSort) sort: MatSort;
  // // -- dataSource = new UserDataSource(this._ProductService);

  // @ViewChild(MatPaginator) paginator: MatPaginator;
  // @ViewChild(MatSort) sort: MatSort;
  // //dataSource: DataTableDataSource;
  // dataSource = new MatTableDataSource<ProductMaster>
  
  //dataSource = new MatTableDataSource<ProductMaster>(this.Temp);
    
  // ngOnInit() {
  //   this.getProdContactsByService();
  // }

  //displayedColumns: string[] = ['position','prodname','abbr','actions'];
  //dataSource = new MatTableDataSource<ProductElement>(ELEMENT_DATA1);
  //dataSource = new MatTableDataSource<ProductMaster>(this.ProductMasterList);
  
  //  @ViewChild(MatPaginator) paginator: MatPaginator;
  //  @ViewChild(MatSort) sort: MatSort;

  // applyFilter(filterValue: string) {
  //   filterValue = filterValue.trim(); // Remove whitespace
  //   filterValue = filterValue.toLowerCase(); // MatTableDataSource defaults to lowercase matches
  //   this.dataSource.filter = filterValue;
  // }


  // applyFilter(filterValue: string) {
  //   filterValue = filterValue.trim(); // Remove whitespace
  //   filterValue = filterValue.toLowerCase(); // Datasource defaults to lowercase matches
  //   this.dataSource.filter = filterValue;
  // }
   //ngOnInit() {

    //this.dataSource = new DataTableDataSource(this.paginator, this.sort,this._ProductService);
      
  //   //this.getTempArray();
  //   //this.getProdContactsByService();
  //   //this.getProd();
  //   //this.getpostContacts();
  //   this.getProdContactsByService();
    // this.getProdContactsByService();
      // this.dataSource.paginator = this.paginator;
      // this.dataSource.sort = this.sort;
  // }


  // ngOnInit(): void {
    
    // this.http.get('data/data.json')
    //   .map(this.extractData)
    //   .subscribe(persons => {
    //     this.persons = persons;
    //     // Calling the DT trigger to manually render the table
        
    //   });
  //}

  // ngAfterViewInit() {
  //   this.dataSource.paginator = this.paginator;
  //   this.dataSource.sort = this.sort;
  // }

  // applyFilter(filterValue: string) {
  //   filterValue = filterValue.trim(); // Remove whitespace
  //   filterValue = filterValue.toLowerCase(); // Datasource defaults to lowercase matches
  //   this.dataSource.filter = filterValue;
  // }
  
  addProductMaster() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(ProductDialogComponent, {
      data: {}
    });

    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  //to edit dialog
  editProductMaster(arr: any[]) {
    //alert(arr);
    console.log(arr);
    this.isPopupOpened = true;
    //const contact = this._ProductService.getAllProductMaster().find(c => c.ID === id);
    // let contact = this._ProductService.getProd().map(res=>res.filter(data =>data.product_id == id))[0];
    // console.log(contact);
    
    const dialogRef = this.dialog.open(ProductDialogComponent, {
      data: arr
    });

    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteProductMaster(id: number) {
    console.log('Deleted ID in List Component',id)
    //this._ProductService.deleteProductMaster(id);
    this._ProductService.deleteMasterDetails(id,'PRODUCTS').subscribe();
    //this._ProductService.deleteProductMaster(id);
  }
  
}
  
  export interface ProductElement {
    ProductName: string;
    ID: number;
    ProductAbbr: string;
  }

  const ELEMENT_DATA1: ProductElement[] = [
      {ID: 1, ProductName: 'Home Loan',ProductAbbr: 'HL'},
      {ID: 2, ProductName: 'Non Residential Premises Loans', ProductAbbr: 'NRPL'},
      {ID: 3, ProductName: 'Loan Against Property', ProductAbbr: 'LAP'},
      {ID: 4, ProductName: 'Business Loans', ProductAbbr: 'BL'},
      {ID: 5, ProductName: 'Personal Loans', ProductAbbr: 'PL'},
      {ID: 6, ProductName: 'Land Loan', ProductAbbr: 'LL'}
  ];
/*

import { Component, OnInit, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';
import { ProductService } from '../../service/product.service';
import { ProductDialogComponent } from '../product-dialog/product-dialog.component';
import { ProductMaster } from '../../model/product-master';
import { DataSource } from '@angular/cdk/table';
import { Observable } from 'rxjs';


@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent implements OnInit {

  isPopupOpened = true;
  
  TempArray : any = [];
  TempArray2 : any = [];
  public  contacts:  Array<object> = [];

  constructor(private dialog: MatDialog,
    private _ProductService: ProductService) { }

   get ProductMasterList() {
     return this._ProductService.getAllProductMaster();
   }

   get ProdList() {
     return this._ProductService.getProd();
    }

  getTempArray() {
    this._ProductService.getProductMasterArrayData()
        .subscribe(_ProductArr => this.TempArray = _ProductArr);
  }

  public  getContacts(){
    this._ProductService.getProd().subscribe((data:  Array<object>) => {
        this.contacts  =  data;
        console.log(data);
    });
 }

 public  getProdComponent(){
  this._ProductService.getProd().subscribe((data:  Array<object>) => {
      this.contacts  =  data;
      console.log(data);
  });
}

 ProductElement = [
  {ID: 1, ProductName: 'Home Loan',ProductAbbr: 'HL'},
  {ID: 2, ProductName: 'Non Residential Premises Loans', ProductAbbr: 'NRPL'},
  {ID: 3, ProductName: 'Loan Against Property', ProductAbbr: 'LAP'},
  {ID: 4, ProductName: 'Business Loans', ProductAbbr: 'BL'},
  {ID: 5, ProductName: 'Personal Loans', ProductAbbr: 'PL'},
  {ID: 6, ProductName: 'Land Loan', ProductAbbr: 'LL'}
];


 public getpostContacts(){
  this._ProductService.addProd({name: 'Non Residential Premises Loans',abbr: 'NRPL'})
  .subscribe(hero => this.TempArray2.push(hero));
 }

  //displayedColumns: string[] = ['ID','ClassifiedName'];
  //dataSource = this.ProductMasterList;

  displayedColumns: string[] = ['position','prodname','abbr','actions'];
  //dataSource = new MatTableDataSource<ProductElement>(ELEMENT_DATA1);
  //dataSource = new MatTableDataSource<ProductEle>(this.ProdList);
  //dataSource = new MatTableDataSource<ProductMaster>(this.ProdList);
  //dataSource = new MatTableDataSource(this.ProdList);
  //dataSource = new UserDataSource(this._ProductService);
  // @ViewChild(MatPaginator) paginator: MatPaginator;
  // @ViewChild(MatSort) sort: MatSort;

  // applyFilter(filterValue: string) {
  //   filterValue = filterValue.trim(); // Remove whitespace
  //   filterValue = filterValue.toLowerCase(); // MatTableDataSource defaults to lowercase matches
  //   this.dataSource.filter = filterValue;
  // }

  ngOnInit() {
    this.getTempArray();
    // this.getContacts();
    // this.getpostContacts();
    // this.dataSource.paginator = this.paginator;
    // this.dataSource.sort = this.sort;
  }

  // ngAfterViewInit() { 
  //   this.dataSource.paginator = this.paginator;
  //   this.dataSource.sort = this.sort;
  //   this.dataSource.sort = this.sort; }

  addProductMaster() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(ProductDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editProductMaster(id: number) {
    alert(id);
    this.isPopupOpened = true;
    const contact = this._ProductService.getAllProductMaster().find(c => c.ID === id);
    const dialogRef = this.dialog.open(ProductDialogComponent, {
      data: contact
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteProductMaster(id: number) {
    this._ProductService.deleteProductMaster(id);
  }


  
}
  
  export interface ProductElement {
    ProductName: string;
    ID: number;
    ProductAbbr: string;
  }


  export interface ProductEle {
    product_id: any;
    name: any;
    abbr: any;
    createdon: any;
    fk_createdby : any;
    updatedon : any;
    isactive : any;
    fk_updatedby :any;
  }

  const ELEMENT_DATA1: ProductElement[] = [
      {ID: 1, ProductName: 'Home Loan',ProductAbbr: 'HL'},
      {ID: 2, ProductName: 'Non Residential Premises Loans', ProductAbbr: 'NRPL'},
      {ID: 3, ProductName: 'Loan Against Property', ProductAbbr: 'LAP'},
      {ID: 4, ProductName: 'Business Loans', ProductAbbr: 'BL'},
      {ID: 5, ProductName: 'Personal Loans', ProductAbbr: 'PL'},
      {ID: 6, ProductName: 'Land Loan', ProductAbbr: 'LL'}
  ];

*/

export class UserDataSource extends DataSource<any> {
  
  // paginator: MatPaginator;
  // sort: MatSort;
  
  constructor(private _ps:MastersService) {
    super();
  }

  connect(): Observable<ProductMaster[]> {
    //return this.userService.getUser();
    return this._ps.getAllProduct();
  }
  disconnect() {}
}



export class DataTableDataSource extends DataSource<any> {

  data:any[] = [];
  //private  contacts:  Array<object> = [];

  constructor(private paginator: MatPaginator, private sort: MatSort, private _ps: MastersService ) {
    super();

    // this._ps.getProd().subscribe((dataresult: any[]) => { // good!
    //   for (let item of dataresult) {
    //     this.data.push(item);
    //   }
    //   console.log("DataTableDataSource Constructor", this.data);
    // });

  }

//   public  getProdContactsByService(){
  
//     this._ps.get2Prod().subscribe((data:  Array<object>) => {
  
//       this.contacts  =  data;
  
//       console.log(data);
//     });
//  }

  //data = this.contacts;

  /**
   * Connect this data source to the table. The table will only update when
   * the returned stream emits new items.
   * @returns A stream of the items to be rendered.
   */
  // connect(): Observable<DataTableItem[]> {
  //   // Combine everything that affects the rendered data into one update
  //   // stream for the data-table to consume.
  //   const dataMutations = [
  //     observableOf(this.data),
  //     this.paginator.page,
  //     this.sort.sortChange
  //   ];

  //   // Set the paginators length
  //   this.paginator.length = this.data.length;

  //   return merge(...dataMutations).pipe(map(() => {
  //     return this.getPagedData(this.getSortedData([...this.data]));
  //   }));
  // }


  connect(): Observable<any[]> {

    
   let newarray = this._ps.getAllProduct().subscribe((dataresult: any[]) => { // good!
      for (let item of dataresult) {
        this.data.push(item);
      }
      return this.data;
    });

    console.log("DataTableDataSource", newarray);

    // return this._ps.getProd();

    // Combine everything that affects the rendered data into one update
    // stream for the data-table to consume.
    const dataMutations = [
      observableOf(newarray),
      this.paginator.page,
      this.sort.sortChange
    ];
    console.log("DataTableDataSource Connect to datasources", newarray);
    // Set the paginators length
    this.paginator.length = this.data.length;
    console.log("DataTableDataSource Page Length", this.paginator.length);

    return merge(...dataMutations).pipe(map(() => {
      return this.getPagedData(this.getSortedData([...this.data]));
    }));
  }

  
  // connect(): Observable<any[]> {
    
  //   //this.data = this._ps.getProd();
  //   this._ps.getProd().subscribe((dataresult: any[]) => { // good!
  //     for (let item of dataresult) {
  //       this.data.push(item);
  //     }
  //     console.log("DataTableDataSource to Connect ", this.data);
  //   });

  //   // Combine everything that affects the rendered data into one update
  //   // stream for the data-table to consume.
  //   // const dataMutations = [
  //   //   observableOf(this.data),
  //   //   this.paginator.page,
  //   //   this.sort.sortChange
  //   // ];
  //   // console.log("DataTableDataSource Connect to datasources", this.data);
  //   // // Set the paginators length
  //   // this.paginator.length = this.data.length;
  //   // console.log("DataTableDataSource Page Length", this.paginator.length);

  //   // return merge(...dataMutations).pipe(map(() => {
  //   //   return this.getPagedData(this.getSortedData([...this.data]));
  //   // }));

  //   //return this.userService.getUser();
  //   return this._ps.getProd();
  // }

  /**
   *  Called when the table is being destroyed. Use this function, to clean up
   * any open connections or free any held resources that were set up during connect.
   */
  disconnect() {}

  /**
   * Paginate the data (client-side). If you're using server-side pagination,
   * this would be replaced by requesting the appropriate data from the server.
   */
  private getPagedData(data: any[]) {
    console.log("DataTableDataSource GetPageData", data);
    const startIndex = this.paginator.pageIndex * this.paginator.pageSize;
    return data.splice(startIndex, this.paginator.pageSize);
  }

  /**
   * Sort the data (client-side). If you're using server-side sorting,
   * this would be replaced by requesting the appropriate data from the server.
   */
  private getSortedData(data: any[]) {
    console.log("DataTableDataSource GetSortedData", data);
    if (!this.sort.active || this.sort.direction === '') {
      return data;
    }

    return data.sort((a, b) => {
      const isAsc = this.sort.direction === 'asc';
      switch (this.sort.active) {
            case 'product_id': return compare(a.product_id, b.product_id, isAsc);
            case 'name': return compare(a.name, b.name, isAsc);
            case 'abbr': return compare(a.abbr, b.abbr, isAsc);
            case 'createdon': return compare(a.createdon, b.createdon, isAsc);
            case 'fk_createdby': return compare(a.fk_createdby, b.fk_createdby, isAsc);
            case 'updatedon': return compare(a.updatedon, b.updatedon, isAsc);
            case 'isactive': return compare(a.isactive, b.isactive, isAsc);
            case 'fk_updatedby': return compare(a.fk_updatedby, b.fk_updatedby, isAsc);
        //  case 'name': return compare(a.name, b.name, isAsc);
        //  case 'amount' : return compare(a.amount,b.amount, isAsc);
        //  case 'id': return compare(+a.id, +b.id, isAsc);
        default: return 0;
      }
    });
  }
}

/** Simple sort comparator for example ID/Name columns (for client-side sorting). */
function compare(a, b, isAsc) {
  return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
}
