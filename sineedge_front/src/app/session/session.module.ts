import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import {
  MatCardModule,
  MatInputModule,
  MatRadioModule,
  MatButtonModule,
  MatProgressBarModule,
  MatToolbarModule } from '@angular/material';

import { MatIconModule} from '@angular/material';
import { FlexLayoutModule } from '@angular/flex-layout';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { LockScreenComponent } from './lockscreen/lockscreen.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { FileUploadModule } from 'ng2-file-upload/ng2-file-upload';
import { TreeModule } from 'angular-tree-component';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';
import { SessionRoutes } from './session.routing';
// import { lenderLoginComponent } from './lenderLogin/lenderLogin.component';
import { loginHomeComponent } from './loginHome/loginHome.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    MatIconModule,
    RouterModule.forChild(SessionRoutes),
    MatCardModule,
    MatIconModule,
    MatInputModule,
    MatRadioModule,
    MatButtonModule,
    MatProgressBarModule,
    MatToolbarModule,
    FlexLayoutModule,
    ReactiveFormsModule,
    FileUploadModule,TreeModule,NgxDatatableModule,
    
    
  ],
  declarations: [ 
    LoginComponent,
    RegisterComponent,
    ForgotPasswordComponent,
    LockScreenComponent,
    
    loginHomeComponent,
    
  ]
})

export class SessionModule {}
