import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './comments-on-locality-dialog.component.html',
  styleUrls: ['./comments-on-locality-dialog.component.scss']
})
export class CommentsOnLocalityDialogComponent implements OnInit {


  public _CommentOnLocalityForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<CommentsOnLocalityDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._CommentOnLocalityForm = this._formBuilder.group({
        //branch_id: any; fk_city_id: any;
          comments_on_locality_id: [this.data.comments_on_locality_id],
          rating: [this.data.rating, Validators.compose([Validators.required])],
      });
    
  }

  
  onSubmit() {
    if(isNaN(this.data.comments_on_locality_id)) {
      var my_array = this._CommentOnLocalityForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'COMMENTSONLOCALITY').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._CommentOnLocalityForm.value,'COMMENTSONLOCALITY').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._CommentOnLocalityForm.reset();
  }
}
