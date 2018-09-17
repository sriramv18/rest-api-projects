import { Routes } from '@angular/router';

import { RegisterComponent } from './register/register.component';
 import { UserListComponent } from './user-list/user-list.component';
 import { MastersComponent } from './component/masters/masters.component';

export const SettingsRoute: Routes = [
  {
    path: '',
    children: [
      //{
      // path: 'userRegister',
      // component: RegisterComponent
      //},
    {
      path:'userListing',
      component:UserListComponent
    },{
      path:'masters',
      component:MastersComponent
    }]
  }
];
