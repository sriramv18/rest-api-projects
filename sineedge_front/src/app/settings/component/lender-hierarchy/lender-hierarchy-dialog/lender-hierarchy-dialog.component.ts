import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './lender-hierarchy-dialog.component.html',
  styleUrls: ['./lender-hierarchy-dialog.component.scss']
})
export class LenderHierarchyDialogComponent implements OnInit {

  public _lenderHierarchyForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<LenderHierarchyDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._lenderHierarchyForm = this._formBuilder.group({
        //Designation_id: any; fk_city_id: any;
          
          lender_hierarchy_id: [this.data.lender_hierarchy_id],
          lender_hierarchy: [this.data.lender_hierarchy, Validators.compose([Validators.required])],
          
      });
    //console.log(this._lenderHierarchyForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addDesignation(this._lenderHierarchyForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editDesignation(this._lenderHierarchyForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.lender_hierarchy_id)) {
      var my_array = this._lenderHierarchyForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'LENDERHIERARCHY').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._lenderHierarchyForm.value,'LENDERHIERARCHY').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._lenderHierarchyForm.reset();
  }
}






