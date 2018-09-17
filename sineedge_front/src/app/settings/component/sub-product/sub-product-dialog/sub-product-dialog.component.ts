import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './sub-product-dialog.component.html',
  styleUrls: ['./sub-product-dialog.component.scss']
})
export class SubProductDialogComponent implements OnInit {

  public _subProductMasterForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<SubProductDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._subProductMasterForm = this._formBuilder.group({
        subproduct_id: [this.data.subproduct_id],
          name: [this.data.name, Validators.compose([Validators.required])],
          fk_product_id: [this.data.fk_product_id, Validators.compose([Validators.required])],
          abbr: [this.data.abbr, Validators.compose([Validators.required])]
      });
    //console.log(this._industryMasterForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addSubProductMaster(this._subProductMasterForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editSubProductMaster(this._subProductMasterForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.subproduct_id)) {
      var my_array = this._subProductMasterForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'SUBPRODUCTS').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._MastersService.editMasterDetails(this._subProductMasterForm.value,'SUBPRODUCTS').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

}