import {Content} from "./content";
import {Author} from "./author";
import {Likes} from "./likes";

export class Publication {
  public readonly id: string;
  public readonly content: Content;
  public readonly author: Author;
  public readonly status: string;
  public readonly likes: Likes;
  public readonly createdAt: Date;

  constructor(id: string, content: Content, author: Author, status: string, likes: Likes, createdAt: Date) {
    this.id = id;
    this.content = content;
    this.author = author;
    this.status = status;
    this.likes = likes;
    this.createdAt = createdAt;
  }
}
