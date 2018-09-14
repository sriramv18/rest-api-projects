import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-designation-dialog',
  templateUrl: './designation-dialog.component.html',
  styleUrls: ['./designation-dialog.component.scss']
})
export class DesignationDialogComponent implements OnInit {

  public _designationForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<DesignationDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._designationForm = this._formBuilder.group({
        //Designation_id: any; fk_city_id: any;
          designation_id: [this.data.designation_id],
          name: [this.data.name, Validators.compose([Validators.required])],
          short_name: [this.data.short_name, Validators.compose([Validators.required])]
      });
    //console.log(this._designationForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addDesignation(this._designationForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editDesignation(this._designationForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.designation_id)) {
      var my_array = this._designationForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'DESIGNATION').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._designationForm.value,'DESIGNATION').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._designationForm.reset();
  }
}






