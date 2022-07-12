export class RegistrationFormData {
  public readonly login: string;
  public readonly email: string;
  public readonly password: string;
  public readonly role: string;

  constructor(
    login: string,
    email: string,
    password: string,
    role: string,
  ) {
    this.login = login;
    this.email = email;
    this.password = password;
    this.role = role;
  }
}
