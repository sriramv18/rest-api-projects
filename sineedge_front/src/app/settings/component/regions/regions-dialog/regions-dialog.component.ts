import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './regions-dialog.component.html',
  styleUrls: ['./regions-dialog.component.scss']
})
export class RegionsDialogComponent implements OnInit {

  public _regionsForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<RegionsDialogComponent>,
  private _regionsService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._regionsForm = this._formBuilder.group({
        //Regions_id: any; fk_city_id: any;
          region_id: [this.data.region_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._regionsForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._regionsService.addRegions(this._regionsForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._regionsService.editRegions(this._regionsForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.region_id)) {
      var my_array = this._regionsForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._regionsService.addMasterDetails(my_array,'REGIONS').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._regionsService.editMasterDetails(this._regionsForm.value,'REGIONS').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._regionsForm.reset();
  }
}
