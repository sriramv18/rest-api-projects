import { Injectable } from '@angular/core';

export interface BadgeItem {
  type: string;
  value: string;
}

export interface ChildrenItems {
  state: string;
  name: string;
  type?: string;
}

export interface Menu {
  state: string;
  name: string;
  type: string;
  icon: string;
  badge?: BadgeItem[];
  children?: ChildrenItems[];
}

const MENUITEMS : Menu[] = [
  {
    state: 'home',
    name: 'HOME',
    type: 'link',
    icon: 'explore'
  },
  
  {
    state: 'material',
    name: 'MATERIAL',
    type: 'sub',
    icon: 'equalizer',
    badge: [
      {type: 'purple', value: '10'}
    ],
    children: [
      {state: 'button', name: 'BUTTON'},
      {state: 'cards', name: 'CARDS'},
      {state: 'select', name: 'SELECT'},
      {state: 'autocomplete', name: 'AUTOCOMPLETE'},
      {state: 'chips', name: 'CHIPS'},
      {state: 'input', name: 'INPUT'},
      {state: 'checkbox', name: 'CHECKBOX'},
      {state: 'radio', name: 'RADIO'},
      {state: 'toolbar', name: 'TOOLBAR'},
      {state: 'lists', name: 'LISTS'},
      {state: 'grid', name: 'GRID'},
      {state: 'progress', name: 'PROGRESS'},
      {state: 'tabs', name: 'TABS'},
      {state: 'switch', name: 'SWITCH'},
      {state: 'tooltip', name: 'TOOLTIP'},
      {state: 'menu', name: 'MENU'},
      {state: 'slider', name: 'SLIDER'},
      {state: 'snackbar', name: 'SNACKBAR'},
      {state: 'dialog', name: 'DIALOG'}
    ]
  },
  {
    state:'settings',
    name:'Settings',
    type:'sub',
    icon:'settings',
    children:[
      {state:'userRegister',name:'User Register'},
      {state:'userListing',name:'User Listing'}
    ]
  },
  // {
  //   state: 'authentication',
  //   name: 'AUTHENTICATION',
  //   type: 'sub',
  //   icon: 'security',
  //   children: [
  //     {state: 'login', name: 'LOGIN'},
  //     {state: 'register', name: 'REGISTER'},
  //     {state: 'forgot-password', name: 'FORGOT'},
  //     {state: 'lockscreen', name: 'LOCKSCREEN'}
  //   ]
  // },
  {
    state: 'error',
    name: 'ERROR',
    type: 'sub',
    icon: 'error_outline',
    children: [
      {state: '404', name: '404'},
      {state: '503', name: '503'}
    ]
  }
];

@Injectable()
export class MenuItems {
  getAll(): Menu[] {
    return MENUITEMS;
  }

  add(menu: Menu) {
    MENUITEMS.push(menu);
  }
}
