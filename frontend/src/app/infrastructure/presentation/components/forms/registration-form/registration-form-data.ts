export class RegistrationFormData {
  public readonly login: string;
  public readonly email: string;
  public readonly password: string;

  constructor(
    login: string,
    email: string,
    password: string,
  ) {
    this.login = login;
    this.email = email;
    this.password = password;
  }
}
