import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

import { MastersService } from  '../../../service/master/masters.service';
@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './city-dialog.component.html',
  styleUrls: ['./city-dialog.component.scss']
})
export class CityDialogComponent implements OnInit {


  public _cityForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<CityDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._cityForm = this._formBuilder.group({
        //City_id: any; fk_city_id: any;
        
          city_id: [this.data.city_id],
          name: [this.data.name, Validators.compose([Validators.required])],
          fk_state_id: [this.data.fk_state_id, Validators.compose([Validators.required])]
      });
    //console.log(this._cityForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addCity(this._cityForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editCity(this._cityForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.city_id)) {
      var my_array = this._cityForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'CITY').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._cityForm.value,'CITY').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._cityForm.reset();
  }
}
