export class AuthToken {
  public readonly type: string;
  public readonly expiresIn: number;
  public readonly accessToken: string;
  public readonly refreshToken: string;

  constructor(
    type: string,
    expiresIn: number,
    accessToken: string,
    refreshToken: string
  ) {
    this.type = type;
    this.expiresIn = expiresIn;
    this.accessToken = accessToken;
    this.refreshToken = refreshToken;
  }
}
