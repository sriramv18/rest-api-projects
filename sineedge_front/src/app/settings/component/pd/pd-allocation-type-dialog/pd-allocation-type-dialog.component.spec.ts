import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdAllocationTypeDialogComponent } from './pd-allocation-type-dialog.component';

describe('PdAllocationTypeDialogComponent', () => {
  let component: PdAllocationTypeDialogComponent;
  let fixture: ComponentFixture<PdAllocationTypeDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdAllocationTypeDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdAllocationTypeDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
