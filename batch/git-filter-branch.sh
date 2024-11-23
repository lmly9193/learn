#!/usr/bin/env bash

BEFORE_NAME="Ethan"
BEFORE_EMAIL="wrong@example.com"
AFTER_NAME="lmly9193"
AFTER_EMAIL="15520160+lmly9193@users.noreply.github.com"

# 修改全部的分支、標籤裡錯誤的名字、信箱
# git filter-branch --force --env-filter '
#     if [ "$GIT_COMMITTER_NAME" == "'"$BEFORE_NAME"'" ] || [ "$GIT_COMMITTER_EMAIL" == "'"$BEFORE_EMAIL"'" ]; then
#         GIT_COMMITTER_NAME="'"$AFTER_NAME"'"
#         GIT_COMMITTER_EMAIL="'"$AFTER_EMAIL"'"
#     fi
#     if [ "$GIT_AUTHOR_NAME" == "'"$BEFORE_NAME"'" ] || [ "$GIT_AUTHOR_EMAIL" == "'"$BEFORE_EMAIL"'" ]; then
#         GIT_AUTHOR_NAME="'"$AFTER_NAME"'"
#         GIT_AUTHOR_EMAIL="'"$AFTER_EMAIL"'"
#     fi' --tag-name-filter cat -- --branches --tags

# 僅修改目前的分支裡錯誤的名字、信箱到HEAD
# git filter-branch --commit-filter '
#     if [ "$GIT_COMMITTER_NAME" == "'"$BEFORE_NAME"'" ] || [ "$GIT_COMMITTER_EMAIL" == "'"$BEFORE_EMAIL"'" ]; then
#         GIT_COMMITTER_NAME="'"$AFTER_NAME"'";
#         GIT_COMMITTER_EMAIL="'"$AFTER_EMAIL"'";
#     fi
#     if [ "$GIT_AUTHOR_NAME" == "'"$BEFORE_NAME"'" ] || [ "$GIT_AUTHOR_EMAIL" == "'"$BEFORE_EMAIL"'" ]; then
#         GIT_AUTHOR_NAME="'"$AFTER_NAME"'";
#         GIT_AUTHOR_EMAIL="'"$AFTER_EMAIL"'";
#     fi
#     git commit-tree "$@"' HEAD

# 全部分支、標籤都修改成正確的名字、信箱，不管名字、信箱是否正確。
git filter-branch --force --env-filter 'GIT_COMMITTER_NAME="'"$AFTER_NAME"'"; GIT_COMMITTER_EMAIL="'"$AFTER_EMAIL"'"; GIT_AUTHOR_NAME="'"$AFTER_NAME"'"; GIT_AUTHOR_EMAIL="'"$AFTER_EMAIL"'"' --tag-name-filter cat -- --branches --tags
