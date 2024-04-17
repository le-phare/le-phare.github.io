FROM ruby:3

COPY Gemfile Gemfile.lock ./

RUN bundle install

ENTRYPOINT ["jekyll", "serve", "--host", "0.0.0.0", "--port", "80", "--destination", "/tmp/_site"]
