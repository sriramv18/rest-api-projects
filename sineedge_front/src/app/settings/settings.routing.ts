import { Routes } from '@angular/router';

import { RegisterComponent } from './register/register.component';
 import { UserListComponent } from './user-list/user-list.component';

export const SettingsRoute: Routes = [
  {
    path: '',
    children: [{
      path: 'userRegister',
      component: RegisterComponent
    },{
      path:'userListing',
      component:UserListComponent
    }]
  }
];
