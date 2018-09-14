import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EntityTypeDialogComponent } from './entity-type-dialog.component';

describe('EntityTypeDialogComponent', () => {
  let component: EntityTypeDialogComponent;
  let fixture: ComponentFixture<EntityTypeDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EntityTypeDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EntityTypeDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
