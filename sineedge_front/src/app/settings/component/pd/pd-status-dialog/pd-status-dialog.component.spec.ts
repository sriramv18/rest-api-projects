import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdStatusDialogComponent } from './pd-status-dialog.component';

describe('PdStatusDialogComponent', () => {
  let component: PdStatusDialogComponent;
  let fixture: ComponentFixture<PdStatusDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdStatusDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdStatusDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
