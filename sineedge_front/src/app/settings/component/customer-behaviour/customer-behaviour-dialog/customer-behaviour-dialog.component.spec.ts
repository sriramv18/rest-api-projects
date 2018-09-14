import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CustomerBehaviourDialogComponent } from './customer-behaviour-dialog.component';

describe('CustomerBehaviourDialogComponent', () => {
  let component: CustomerBehaviourDialogComponent;
  let fixture: ComponentFixture<CustomerBehaviourDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CustomerBehaviourDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CustomerBehaviourDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
