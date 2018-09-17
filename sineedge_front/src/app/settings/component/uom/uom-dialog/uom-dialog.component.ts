import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './uom-dialog.component.html',
  styleUrls: ['./uom-dialog.component.scss']
})
export class UomDialogComponent implements OnInit {


  public _uomForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<UomDialogComponent>,
  private _mastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._uomForm = this._formBuilder.group({
          // ID: [this.data.ID],
          // Name: [this.data.Name, Validators.compose([Validators.required])]
          // uom_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
          uom_id: [this.data.uom_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._UomForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._mastersService.addUom(this._uomForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._mastersService.editUom(this._uomForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.subproduct_id)) {
      var my_array = this._uomForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._mastersService.addMasterDetails(my_array,'UOM').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._mastersService.editMasterDetails(this._uomForm.value,'UOM').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  onReset(){
    this._uomForm.reset();
  }
}
