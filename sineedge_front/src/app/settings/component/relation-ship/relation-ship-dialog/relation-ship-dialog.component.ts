import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';



@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './relation-ship-dialog.component.html',
  styleUrls: ['./relation-ship-dialog.component.scss']
})
export class RelationShipDialogComponent implements OnInit {


  public _relationShipForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef< RelationShipDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._relationShipForm = this._formBuilder.group({
          relationship_id: [this.data.relationship_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._relationShipForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addRelationShip(this._relationShipForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editRelationShip(this._relationShipForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.relationship_id)) {
      var my_array = this._relationShipForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'RELATIONSHIPS').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._MastersService.editMasterDetails(this._relationShipForm.value,'RELATIONSHIPS').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  onReset(){
    this._relationShipForm.reset();
  }
}
