import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './pd-allocation-type-dialog.component.html',
  styleUrls: ['./pd-allocation-type-dialog.component.scss']
})
export class PdAllocationTypeDialogComponent implements OnInit {


  
  public _PDAllocationTypeForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<PdAllocationTypeDialogComponent>,
  private _pds: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._PDAllocationTypeForm = this._formBuilder.group({
        pd_allocation_type_id: [this.data.pd_allocation_type_id],
        pd_allocation_type_name: [this.data.pd_allocation_type_name, Validators.compose([Validators.required])]
      });
      //pd_allocation_type_id, pd_allocation_type_name, createdon, fk_createdby, updatedon, isactive
    //console.log(this._PDAllocationTypeForm);
  }

  onSubmit() {
    if(isNaN(this.data.pd_allocation_type_id)) {
      var my_array = this._PDAllocationTypeForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._pds.addMasterDetails(my_array,'PDALLOCATIONTYPE').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._pds.editMasterDetails(this._PDAllocationTypeForm.value,'PDALLOCATIONTYPE').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._memberService.addMembersOccupation(this._PDAllocationTypeForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._memberService.editMembersOccupation(this._PDAllocationTypeForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onReset(){
    this._PDAllocationTypeForm.reset();
  }
}









