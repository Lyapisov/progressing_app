export class Likes {
  public readonly count: number;
  public readonly authorsId: any;

  constructor(count: number, authorsId: any) {
    this.count = count;
    this.authorsId = authorsId;
  }
}
