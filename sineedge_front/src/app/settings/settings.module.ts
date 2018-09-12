import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import {
  MatCardModule,
  MatIconModule,
  MatInputModule,
  MatRadioModule, 
  MatButtonModule,MatTableModule,MatPaginatorModule,
  MatProgressBarModule,MatDialogModule,
  MatToolbarModule,MatSelectModule  } from '@angular/material';
  import {MatSlideToggleModule} from '@angular/material/slide-toggle';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { FileUploadModule } from 'ng2-file-upload/ng2-file-upload';
import { TreeModule } from 'angular-tree-component';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';
import { FlexLayoutModule } from '@angular/flex-layout';

import { SettingsRoute } from './settings.routing';
import { RegisterComponent } from './register/register.component';
import { UserListComponent } from './user-list/user-list.component';
@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(SettingsRoute),
    MatCardModule,
    MatIconModule,
    MatInputModule,
    MatRadioModule,
    MatTableModule,
    MatPaginatorModule,
    MatButtonModule,
    MatProgressBarModule,
    MatToolbarModule,
    FlexLayoutModule,
    NgxDatatableModule,
    FormsModule,MatSlideToggleModule,
    MatSelectModule,
    ReactiveFormsModule,
    FileUploadModule,
    TreeModule,
    MatDialogModule
  ],
  declarations: [ 
    RegisterComponent,
    UserListComponent, 
  ] 
})
export class SettingsModule { }
