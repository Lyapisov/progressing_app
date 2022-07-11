export class LoginFormData {
  public readonly login: string;
  public readonly password: string;

  constructor(login: string, password: string) {
    this.login = login;
    this.password = password;
  }
}
