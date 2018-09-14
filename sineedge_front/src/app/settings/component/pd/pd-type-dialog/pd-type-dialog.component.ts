import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './pd-type-dialog.component.html',
  styleUrls: ['./pd-type-dialog.component.scss']
})
export class PdTypeDialogComponent implements OnInit {

  public _pdTypeForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<PdTypeDialogComponent>,
  private _pdTypeService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._pdTypeForm = this._formBuilder.group({
        //branch_id: any; fk_city_id: any;pd_type_id, type_name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
        pd_type_id: [this.data.pd_type_id],
        type_name: [this.data.type_name, Validators.compose([Validators.required])]
      });
    //console.log(this._pdTypeForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._pdTypeService.addBranch(this._pdTypeForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._pdTypeService.editBranch(this._pdTypeForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.pd_type_id)) {
      var my_array = this._pdTypeForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._pdTypeService.addMasterDetails(my_array,'PDTYPE').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._pdTypeService.editMasterDetails(this._pdTypeForm.value,'PDTYPE').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._pdTypeForm.reset();
  }
}