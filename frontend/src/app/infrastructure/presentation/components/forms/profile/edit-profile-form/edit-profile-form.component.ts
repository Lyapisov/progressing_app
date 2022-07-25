import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormGroup,
} from '@angular/forms';
import { EditProfileFormData } from './edit-profile-form-data';
import {GetMineUserHandlerService} from "../../../../../../application/users/get-mine-user-handler.service";
import {User} from "../../../../../../application/users/user";
import {Profile} from "../../../../../../application/profiles/profile";
import {DateFormatter} from "../../../../../services/formatters/date/date-formatter";
import {FormBuilderService} from "../../../../../services/form/form-builder.service";
import {ProfileFormBuilder} from "../../base/models/builders/profile-form-builder";
import {BaseForm} from "../../base/models/base-form";
import {GetFanProfileHandlerService} from "../../../../../../application/profiles/get-fan-profile-handler.service";
import {GetMusicianProfileHandlerService} from "../../../../../../application/profiles/get-musician-profile-handler.service";
import {GetProducerProfileHandlerService} from "../../../../../../application/profiles/get-producer-profile-handler.service";

@Component({
  selector: 'app-edit-profile-form',
  templateUrl: './edit-profile-form.component.html',
  styleUrls: ['./edit-profile-form.component.scss']
})
export class EditProfileFormComponent implements OnInit {
  editForm: FormGroup;
  @Output() submitEmitter: EventEmitter<EditProfileFormData> = new EventEmitter();

  public userData: User|null = null;
  public profileData: Profile|null = null;

  public fields: BaseForm<string>[]|null = [];

  constructor(
    private getMineUserHandler: GetMineUserHandlerService,
    private getFanProfileHandler: GetFanProfileHandlerService,
    private getMusicianProfileHandler: GetMusicianProfileHandlerService,
    private getProducerProfileHandler: GetProducerProfileHandlerService,
    private formBuilder: FormBuilderService,
    private dateFormatter: DateFormatter,
  ) {
  }

  ngOnInit() {
    this.getData();
  }

  private getData(): void {
    this.getMineUserHandler.execute()
      .subscribe((foundUser: User) => {
        this.userData = foundUser;
        this.findProfile(foundUser);
      });
  }

  private findProfile(user: User): void {
    if (!user.profileCreated) {
      return;
    }

    if (user.fanId) {
      this.getFanProfileHandler.execute(user.fanId)
        .subscribe((fan: Profile) => {
          this.profileData = fan;
          this.editForm = this.initForm();
        })
    }
    if (user.musicianId) {
      this.getMusicianProfileHandler.execute(user.musicianId)
        .subscribe((musician: Profile) => {
          this.profileData = musician;
          this.editForm = this.initForm();
        })
    }
    if (user.producerId) {
      this.getProducerProfileHandler.execute(user.producerId)
        .subscribe((producer: Profile) => {
          this.profileData = producer;
          this.editForm = this.initForm();
        })
    }
  }

  private initForm(): FormGroup {
    this.fields = ProfileFormBuilder.createWithValues({
      firstName: this.profileData.personalData.firstName,
      lastName: this.profileData.personalData.lastName,
      fatherName: this.profileData.personalData.fatherName,
      birthday: this.dateFormatter.createDateStringFromTimestamp(this.profileData.personalData.birthday),
      phone: this.profileData.personalData.phoneNumber,
      address: this.profileData.personalData.address
    });

    return this.formBuilder.toFormGroup(this.fields)
  }

  firstNameControl(): AbstractControl {
    return this.editForm.get('firstName');
  }

  lastNameControl(): AbstractControl {
    return this.editForm.get('lastName');
  }

  fatherNameControl(): AbstractControl {
    return this.editForm.get('fatherName');
  }

  birthdayControl(): AbstractControl {
    return this.editForm.get('birthday');
  }

  phoneControl(): AbstractControl {
    return this.editForm.get('phone');
  }

  addressControl(): AbstractControl {
    return this.editForm.get('address');
  }

  onSubmit() {
    this.submitEmitter.emit(
      new EditProfileFormData(
        this.firstNameControl().value,
        this.lastNameControl().value,
        this.fatherNameControl().value,
        this.birthdayControl().value,
        this.addressControl().value,
        this.phoneControl().value,
      )
    );
  }
}
