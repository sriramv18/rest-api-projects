import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RelationShipDialogComponent } from './relation-ship-dialog.component';

describe('RelationShipDialogComponent', () => {
  let component: RelationShipDialogComponent;
  let fixture: ComponentFixture<RelationShipDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RelationShipDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RelationShipDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
