import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';


import { MatIconModule, MatCardModule, MatButtonModule, MatListModule, MatInputModule,MatProgressBarModule, MatMenuModule } from '@angular/material';
import { FlexLayoutModule } from '@angular/flex-layout';

import { UserProfileComponent } from './user-profile/user-profile.component';
import { UserListComponent } from './user-list/userlist.component';

import { UsersRoutes } from './users.routing';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule.forChild(UsersRoutes),
     MatIconModule,
     MatIconModule, MatCardModule, MatButtonModule, MatListModule, MatInputModule, MatMenuModule,
   FlexLayoutModule
  ],
  declarations: [ 
    UserProfileComponent,
    UserListComponent
  ]
})

export class UsersModule {}
