import {Comment} from "./entry";

export class CommentFactory {

  static empty():Comment {
    return new Comment(9, "Dein Kommentar", 1);
  }

  static fromObject(rawComment:any):Comment{
    return new Comment(
      rawComment.id,
      rawComment.content,
      rawComment.entry_id
    )
  }
}
