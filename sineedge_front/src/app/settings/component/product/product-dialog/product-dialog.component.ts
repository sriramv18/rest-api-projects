import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './product-dialog.component.html',
  styleUrls: ['./product-dialog.component.scss']
})

export class ProductDialogComponent implements OnInit {

  public _productMasterForm: FormGroup;
  
  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<ProductDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
  }
  
  ngOnInit() {

      this._productMasterForm = this._formBuilder.group({
          //ID: [this.data.ID],
          product_id: [this.data.product_id],
          name: [this.data.name, Validators.compose([Validators.required])],
          abbr: [this.data.abbr, Validators.compose([Validators.required])]
      });
    console.log(this._productMasterForm);
  }

  onSubmit() {
    if(isNaN(this.data.product_id)) {
      
      var my_array = this._productMasterForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      //this._MastersService.addProductMaster(this._productMasterForm.value);
      //this._MastersService.addProd(this._productMasterForm.value).subscribe(data=>this.array=data);
      this._MastersService.addMasterDetails(my_array,'PRODUCTS').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      //this._MastersService.editProductMaster(this._productMasterForm.value);
      this._MastersService.editMasterDetails(this._productMasterForm.value,'PRODUCTS').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

}