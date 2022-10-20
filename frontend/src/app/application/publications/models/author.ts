export class Author{
  public readonly id: string;
  public readonly fullName: string;
  public readonly role: string;

  constructor(id: string, fullName: string, role: string) {
    this.id = id;
    this.fullName = fullName;
    this.role = role;
  }
}
