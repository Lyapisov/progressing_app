export class CreateProfileFormData {
  public readonly firstName: string;
  public readonly lastName: string;
  public readonly fatherName: string;
  public readonly birthday: Date;
  public readonly address: string;
  public readonly phone: string;

  constructor(
    firstName: string,
    lastName: string,
    fatherName: string,
    birthday: Date,
    address: string,
    phone: string
  ) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.fatherName = fatherName;
    this.birthday = birthday;
    this.address = address;
    this.phone = phone;
  }
}
