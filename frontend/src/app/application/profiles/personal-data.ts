export class PersonalData {
  public readonly firstName: string;
  public readonly lastName: string;
  public readonly fatherName: string;
  public readonly phoneNumber: string;
  public readonly address: string;
  public readonly birthday: Date;

  constructor(
    firstName: string,
    lastName: string,
    fatherName: string,
    phoneNumber: string,
    address: string,
    birthday: Date
  ) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.fatherName = fatherName;
    this.phoneNumber = phoneNumber;
    this.address = address;
    this.birthday = birthday;
  }
}
