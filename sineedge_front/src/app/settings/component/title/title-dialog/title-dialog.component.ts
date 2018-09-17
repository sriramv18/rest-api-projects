import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './title-dialog.component.html',
  styleUrls: ['./title-dialog.component.scss']
})
export class TitleDialogComponent implements OnInit {


  public _titleForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<TitleDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._titleForm = this._formBuilder.group({
         title_id: [this.data.title_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._titleForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._contactService.addTitle(this._titleForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._contactService.editTitle(this._titleForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.title_id)) {
      var my_array = this._titleForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'TITLES').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._MastersService.editMasterDetails(this._titleForm.value,'TITLES').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  onReset(){
    this._titleForm.reset();
  }
}

