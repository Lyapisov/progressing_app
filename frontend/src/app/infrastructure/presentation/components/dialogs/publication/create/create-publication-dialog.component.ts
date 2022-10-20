import {Component, OnInit} from '@angular/core';
import {FormBuilder} from "@angular/forms";
import {MatDialogRef} from "@angular/material/dialog";
import {PublicationFormData} from "../../../forms/publications/create/publication-form-data";
import {
  CreatePublicationHandlerService
} from "../../../../../../application/publications/handlers/create-publication--handler.service";

@Component({
  selector: 'dialog-create-publication',
  templateUrl: './create-publication-dialog.component.html',
  styleUrls: ['./create-publication-dialog.component.scss']
})
export class CreatePublicationDialogComponent implements OnInit {
  constructor(
    private formBuilder: FormBuilder,
    private dialogRef: MatDialogRef<CreatePublicationDialogComponent>,
    private createHandler: CreatePublicationHandlerService,
  ) { }

  ngOnInit(): void {

  }

  createPublication(data: PublicationFormData) {
    this.createHandler.execute(
      data.title,
      data.text,
      data.imageId,
    ).subscribe(() => {});
  }

  close() {
    this.dialogRef.close();
  }

}
