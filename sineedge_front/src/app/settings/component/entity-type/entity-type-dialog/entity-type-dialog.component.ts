import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-designation-dialog',
  templateUrl: './entity-type-dialog.component.html',
  styleUrls: ['./entity-type-dialog.component.scss']
})
export class EntityTypeDialogComponent implements OnInit {

  public _entityTypeForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<EntityTypeDialogComponent>,
  private _ETService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._entityTypeForm = this._formBuilder.group({
        //Designation_id: any; fk_city_id: any;
          entity_type_id: [this.data.entity_type_id],
          name: [this.data.name, Validators.compose([Validators.required])]
          
      });
    //console.log(this._entityTypeForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addDesignation(this._entityTypeForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editDesignation(this._entityTypeForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.entity_type_id)) {
      var my_array = this._entityTypeForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._ETService.addMasterDetails(my_array,'ENTITYTYPE').subscribe();
      //addEntityType(my_array)
      this.dialogRef.close();
      alert("saved");
    } else {
      this._ETService.editMasterDetails(this._entityTypeForm.value,'ENTITYTYPE').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._entityTypeForm.reset();
  }
}






