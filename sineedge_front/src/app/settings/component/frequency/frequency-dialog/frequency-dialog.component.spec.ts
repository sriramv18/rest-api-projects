import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FrequencyDialogComponent } from './frequency-dialog.component';

describe('FrequencyDialogComponent', () => {
  let component: FrequencyDialogComponent;
  let fixture: ComponentFixture<FrequencyDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FrequencyDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FrequencyDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
