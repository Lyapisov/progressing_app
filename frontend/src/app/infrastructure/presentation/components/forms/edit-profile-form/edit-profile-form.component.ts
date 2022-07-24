import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  Validators
} from '@angular/forms';
import { EditProfileFormData } from './edit-profile-form-data';
import {GetMineUserHandlerService} from "../../../../../application/users/get-mine-user-handler.service";
import {GetFanProfileHandlerService} from "../../../../../application/profiles/get-profile-handler.service";
import {User} from "../../../../../application/users/user";
import {Profile} from "../../../../../application/profiles/profile";
import {DateFormatter} from "../../../../services/Formatter/Date/DateFormatter";

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

  constructor(
    private formBuilder: FormBuilder,
    private getMineUserHandler: GetMineUserHandlerService,
    private getFanProfileHandler: GetFanProfileHandlerService,
    private dateFormatter: DateFormatter
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
  }

  private initForm(): FormGroup {
    return this.formBuilder.group({
      firstName: [this.profileData.personalData.firstName, [Validators.required]],
      lastName: [this.profileData.personalData.lastName],
      fatherName: [this.profileData.personalData.fatherName],
      birthday: [this.dateFormatter.createDateStringFromTimestamp(this.profileData.personalData.birthday), [Validators.required]],
      phone: [this.profileData.personalData.phoneNumber],
      address: [this.profileData.personalData.address],
    });
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
