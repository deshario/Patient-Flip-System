import pusher

pusher_client = pusher.Pusher(
  app_id='409833',
  key='6d49c0fafb127faf5241',
  secret='33e9136b11a25334312e',
  cluster='ap1',
  ssl=True
)

pusher_client.trigger('my-channel', 'my-event', {'message':7}) #Turning id