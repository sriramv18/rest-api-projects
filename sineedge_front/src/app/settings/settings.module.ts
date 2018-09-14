import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http'
import { HttpModule } from '@angular/http';

import {
  MatCardModule,
  MatIconModule,
  MatInputModule,
  MatRadioModule, 
  MatButtonModule,MatTableModule,MatPaginatorModule,
  MatProgressBarModule,MatDialogModule, MatSortModule,
  MatToolbarModule,MatSelectModule  } from '@angular/material';
import {MatSlideToggleModule} from '@angular/material/slide-toggle';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { FileUploadModule } from 'ng2-file-upload/ng2-file-upload';
import { TreeModule } from 'angular-tree-component';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';
import { FlexLayoutModule } from '@angular/flex-layout';

import { DemoMaterialModule } from '../shared/demo.module';
import { NgxMatSelectSearchModule } from 'ngx-mat-select-search';
import 'hammerjs';

import { SettingsRoute } from './settings.routing';

import { RegisterComponent } from './register/register.component';
import { UserListComponent } from './user-list/user-list.component';

/** Master Main Component */
import { MastersComponent } from './component/masters/masters.component';

/** Master Child Component  - For Listing screen*/
import { IndustryClassificationListComponent } from './component/industry_classification/industry_classification-list/industry_classification-list.component';
import { ProductListComponent } from './component/product/product-list/product-list.component';
import { SubProductListComponent } from './component/sub-product/sub-product-list/sub-product-list.component';
import { BranchListComponent } from './component/branch/branch-list/branch-list.component';
import { TitleListComponent } from './component/title/title-list/title-list.component';
import { RelationShipListComponent } from './component/relation-ship/relation-ship-list/relation-ship-list.component';
import { MembersOccupationListComponent } from './component/members-occupation/members-occupation-list/members-occupation-list.component';
import { ActivityListComponent } from './component/type-of-activity/activity-list/activity-list.component'; 
import { UomListComponent } from './component/uom/uom-list/uom-list.component';
import { FrequencyListComponent } from './component/frequency/frequency-list/frequency-list.component';
import { StatesListComponent } from './component/states/states-list/states-list.component';
import { CityListComponent } from './component/city/city-list/city-list.component';
import { CompanyListComponent } from './component/company/company-list/company-list.component';
import { CustomerSegmentListComponent } from './component/customer-segment/customer-segment-list/customer-segment-list.component';
import { CustomerBehaviourListComponent } from './component/customer-behaviour/customer-behaviour-list/customer-behaviour-list.component';
import { DesignationListComponent } from './component/designation/designation-list/designation-list.component';
import { RegionsListComponent } from './component/regions/regions-list/regions-list.component';
import { CommentsOnLocalityListComponent } from './component/comments-on-locality/comments-on-locality-list/comments-on-locality-list.component';
import { PdAllocationTypeListComponent } from './component/pd/pd-allocation-type-list/pd-allocation-type-list.component';
import { PdLocationApproachListComponent } from './component/pd/pd-location-approach-list/pd-location-approach-list.component';
import { PdTypeListComponent } from './component/pd/pd-type-list/pd-type-list.component';
import { PdStatusListComponent } from './component/pd/pd-status-list/pd-status-list.component';
import { LenderHierarchyListComponent } from './component/lender-hierarchy/lender-hierarchy-list/lender-hierarchy-list.component';

/** Master Child Component  - For Dialogboxes*/
import { ProductDialogComponent } from './component/product/product-dialog/product-dialog.component';
import { IndustryClassificationDialogComponent } from './component/industry_classification/industry_classification-dialog/industry_classification-dialog.component';
import { SubProductDialogComponent } from './component/sub-product/sub-product-dialog/sub-product-dialog.component';
import { BranchDialogComponent } from './component/branch/branch-dialog/branch-dialog.component';
import { TitleDialogComponent } from './component/title/title-dialog/title-dialog.component';
import { RelationShipDialogComponent } from './component/relation-ship/relation-ship-dialog/relation-ship-dialog.component';
import { MembersOccupationDialogComponent } from './component/members-occupation/members-occupation-dialog/members-occupation-dialog.component';
import { ActivityDialogComponent } from './component/type-of-activity/activity-dialog/activity-dialog.component';
import { UomDialogComponent } from './component/uom/uom-dialog/uom-dialog.component';
import { FrequencyDialogComponent } from './component/frequency/frequency-dialog/frequency-dialog.component';
import { PdTypeDialogComponent } from './component/pd/pd-type-dialog/pd-type-dialog.component';
import { PdLocationApproachDialogComponent } from './component/pd/pd-location-approach-dialog/pd-location-approach-dialog.component';
import { PdAllocationTypeDialogComponent } from './component/pd/pd-allocation-type-dialog/pd-allocation-type-dialog.component';
import { PdStatusDialogComponent } from './component/pd/pd-status-dialog/pd-status-dialog.component';
import { LenderHierarchyDialogComponent } from './component/lender-hierarchy/lender-hierarchy-dialog/lender-hierarchy-dialog.component';
import { CommentsOnLocalityDialogComponent } from './component/comments-on-locality/comments-on-locality-dialog/comments-on-locality-dialog.component';
import { DesignationDialogComponent } from './component/designation/designation-dialog/designation-dialog.component';
import { CustomerBehaviourDialogComponent } from './component/customer-behaviour/customer-behaviour-dialog/customer-behaviour-dialog.component';
import { CustomerSegmentDialogComponent } from './component/customer-segment/customer-segment-dialog/customer-segment-dialog.component';
import { StatesDialogComponent } from './component/states/states-dialog/states-dialog.component';
import { CompanyDialogComponent } from './component/company/company-dialog/company-dialog.component';
import { CityDialogComponent } from './component/city/city-dialog/city-dialog.component';
import { RegionsDialogComponent } from './component/regions/regions-dialog/regions-dialog.component';


/** Master Service */
import { MastersService } from './service/master/masters.service';


@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(SettingsRoute),
    MatCardModule,
    MatIconModule,
    MatInputModule,
    MatRadioModule,
    MatTableModule,
    MatPaginatorModule,
    MatButtonModule,
    MatProgressBarModule,
    MatToolbarModule,
    FlexLayoutModule,
    NgxDatatableModule,
    FormsModule,MatSlideToggleModule,
    MatSelectModule,
    ReactiveFormsModule,
    FileUploadModule,
    TreeModule,
    MatDialogModule,
    NgxMatSelectSearchModule
  ],
  declarations: [ 
    RegisterComponent,
    UserListComponent, 

    MastersComponent, 

    IndustryClassificationListComponent, 
    ProductListComponent, 
    SubProductListComponent, 
    BranchListComponent, 
    TitleListComponent, 
    RelationShipListComponent, 
    MembersOccupationListComponent, 
    ActivityListComponent, 
    UomListComponent, 
    FrequencyListComponent, 
    //DataTableComponent, UsertableComponent,  
    StatesListComponent,  
    CityListComponent,  
    CompanyListComponent,  
    CustomerSegmentListComponent,  
    CustomerBehaviourListComponent,  
    DesignationListComponent,  
    RegionsListComponent,  
    CommentsOnLocalityListComponent,  
    PdAllocationTypeListComponent,  
    PdLocationApproachListComponent,  
    PdStatusListComponent,  
    PdTypeListComponent, 
    LenderHierarchyListComponent,
     ProductDialogComponent,
     IndustryClassificationDialogComponent,
     SubProductDialogComponent,
     BranchDialogComponent,
     TitleDialogComponent,
     RelationShipDialogComponent,
     MembersOccupationDialogComponent,
     ActivityDialogComponent, 
     UomDialogComponent, 
     FrequencyDialogComponent,
     PdTypeDialogComponent,
     PdLocationApproachDialogComponent,
     PdAllocationTypeDialogComponent,
     PdStatusDialogComponent,
     // //EntityTypeDialogComponent,
     LenderHierarchyDialogComponent,
     CommentsOnLocalityDialogComponent,
     DesignationDialogComponent,
     CustomerBehaviourDialogComponent,
     CustomerSegmentDialogComponent,
     StatesDialogComponent,
     CompanyDialogComponent,
     CityDialogComponent,
     RegionsDialogComponent
],
providers: [ MastersService ],

entryComponents: [
  IndustryClassificationDialogComponent,
  ProductDialogComponent,
  SubProductDialogComponent,
  BranchDialogComponent,
  TitleDialogComponent,
  RelationShipDialogComponent,
  MembersOccupationDialogComponent,
  ActivityDialogComponent, 
  UomDialogComponent, 
  FrequencyDialogComponent,
  PdTypeDialogComponent,
  PdLocationApproachDialogComponent,
  PdAllocationTypeDialogComponent,
  PdStatusDialogComponent,
  //EntityTypeDialogComponent,
  LenderHierarchyDialogComponent,
  CommentsOnLocalityDialogComponent,
  DesignationDialogComponent,
  CustomerBehaviourDialogComponent,
  CustomerSegmentDialogComponent,
  StatesDialogComponent,
  CompanyDialogComponent,
  CityDialogComponent,
  RegionsDialogComponent],
})
export class SettingsModule { }
