//import { Component, OnInit } from '@angular/core';
//import { FormControl } from '@angular/forms';
//import { startWith } from 'rxjs/operators';


  import { AfterViewInit, Component, OnDestroy, OnInit, ViewChild } from '@angular/core';
  import { FormControl, FormGroup, FormBuilder } from '@angular/forms';
  import { ReplaySubject } from 'rxjs';
  import { MatSelect } from '@angular/material';
  import { Subject } from 'rxjs';
  import { take, takeUntil } from 'rxjs/operators';
  
  export interface Master {
    id: string;
    name: string;
  }
  
// export interface masterArray {
//   value: string;
//   viewValue: string;
// }

@Component({
  selector: 'app-masters',
  templateUrl: './masters.component.html',
  styleUrls: ['./masters.component.scss']
})
export class MastersComponent implements OnInit {
  
    /* Normal Search Code
    pickUpMasterData : string;

    constructor() {}
    
        For Master Dropdown Elements 
    masterArray = [{ code: 'master-1', viewValue: 'Industry Classfication' },
                   { code: 'master-2', viewValue: 'Product'},
                   { code: 'master-3', viewValue: 'Sub Product'}
                  ];
      
    ngOnInit() {}*/
 


/* AutoComplete Code
  stateCtrl: FormControl;
  currentState = '';

  reactiveStates: any;
  tdStates: any[];

  tdDisabled = false;

  tdAuto: string;

  reactiveAuto: string;

  masterArray = [{ code: 'master-1', viewValue: 'Industry Classfication' },
  { code: 'master-2', viewValue: 'Product'},
  { code: 'master-3', viewValue: 'Sub Product'}
 ];

  constructor() {
    this.tdStates = this.masterArray;
    //this.reactiveStates = this.stateCtrl.valueChanges;
  }

  
  filterStates(val: string) {
    return val ? this.masterArray.filter((s) => s.viewValue.match(new RegExp(val, 'gi'))) : this.masterArray;
  }*/

  /* Select Search Code
  /** control for the selected bank */
  public masterCtrl: FormControl = new FormControl();

  /** control for the MatSelect filter keyword */
   public masterFilterCtrl: FormControl = new FormControl();
  

  constructor(private _formBuilder: FormBuilder) { }

  /** list of masters */
  private masters: Master[] = [
    {id: 'master-1',name: 'Industry Classfication'},
    {id: 'master-2',name: 'Branch'},
    {id: 'master-3',name: 'Title'},
    {id: 'master-4',name: 'Relation Ship'},
    {id: 'master-5',name: 'Product'},
    {id: 'master-6',name: 'Sub Product'},
    {id: 'master-7',name: 'Occupation of Non earning members'},
    {id: 'master-8',name: 'Type of activity'},
    {id: 'master-9',name: 'Unit of Measurement'},
    {id: 'master-10',name: 'Frequency'},
    {id: 'master-11',name: 'Approach to PD location'},
    {id: 'master-12',name: 'Comments on locality'},
    {id: 'master-13',name: 'Customer Behaviour'},
    {id: 'master-14',name: 'Customer Segment'},
    {id: 'master-15',name: 'Designation'},
    {id: 'master-16',name: 'PD Allocation Type'},
    {id: 'master-17',name: 'PD Status'},
    {id: 'master-18',name: 'PD Type'},
    {id: 'master-19',name: 'Company Details'},
    {id: 'master-20',name: 'City'},
    {id: 'master-21',name: 'States'},
    {id: 'master-22',name: 'Regions'},
    {id: 'master-23',name: 'm_lender_hierarchy'},
    {id: 'master-24',name: 'm_entity_type'},
    {id: 'datatable',name: 'datatable'},
    {id: 'usertable',name: 'usertable'}
    
  ];

  /** list of masters filtered by search keyword */
  public filteredMasters: ReplaySubject<Master[]> = new ReplaySubject<Master[]>(1);

  
  @ViewChild('singleSelect') singleSelect: MatSelect;
  
  /** Subject that emits when the component has been destroyed. */
  private _onDestroy = new Subject<void>();

  ngOnInit() {
    
    // load the initial master list
    this.filteredMasters.next(this.masters.slice());
    
    // listen for search field value changes
    this.masterFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterMasters();
      });
    
  }

  ngAfterViewInit() {
    //this.setInitialValue();
  }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  // /**
  //  * Sets the initial value after the filteredMasters are loaded initially
  //  */
  // private setInitialValue() {
  //   this.filteredMasters
  //     .pipe(take(1), takeUntil(this._onDestroy))
  //     .subscribe(() => {
  //       // setting the compareWith property to a comparison function
  //       // triggers initializing the selection according to the initial value of
  //       // the form control (i.e. _initializeSelection())
  //       // this needs to be done after the filteredBanks are loaded initially
  //       // and after the mat-option elements are available
  //      this.singleSelect.compareWith = (a: Bank, b: Bank) => a.id === b.id;
  //     });
  // }

  private filterMasters() {
    if (!this.masters) {
      return;
    }
    // get the search keyword
    let search = this.masterFilterCtrl.value;
    if (!search) {
      this.filteredMasters.next(this.masters.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the masters
    this.filteredMasters.next(
      this.masters.filter(master => master.name.toLowerCase().indexOf(search) > -1)
    );
  }

}
