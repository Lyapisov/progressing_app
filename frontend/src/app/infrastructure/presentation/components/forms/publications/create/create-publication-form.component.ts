import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormGroup,
} from '@angular/forms';
import { PublicationFormData } from './publication-form-data';
import {BaseForm} from "../../base/models/base-form";
import {PublicationFormBuilder} from "../../base/models/builders/publication-form-builder";
import {FormBuilderService} from "../../../../../services/form/form-builder.service";

@Component({
  selector: 'app-publication-form',
  templateUrl: './create-publication-form.component.html',
  styleUrls: ['./create-publication-form.component.scss']
})
export class CreatePublicationFormComponent implements OnInit {
  publicationForm!: FormGroup;
  fields: BaseForm<string>[]|null = [];

  @Output() submitEmitter: EventEmitter<PublicationFormData> = new EventEmitter();

  constructor(
    private formBuilder: FormBuilderService
  ) {}

  ngOnInit() {
    this.publicationForm = this.initForm();
  }

  private initForm(): FormGroup {
    this.fields = PublicationFormBuilder.createDefault();
    return this.formBuilder.toFormGroup(this.fields)
  }

  titleControl(): AbstractControl {
    return this.publicationForm.get('title');
  }

  textControl(): AbstractControl {
    return this.publicationForm.get('text');
  }

  imageControl(): AbstractControl {
    return this.publicationForm.get('imageId');
  }

  onSubmit() {
    this.submitEmitter.emit(
      new PublicationFormData(
        this.titleControl().value,
        this.textControl().value,
        this.imageControl().value,
      )
    );
  }
}
